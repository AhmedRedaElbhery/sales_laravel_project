<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OcrService
{

    // ghostscript and ocr
    //////////////////////////////////////////////////////////////////////////
    public function convertPdfToImages(string $pdfPath): array
    {
        $outputDir = storage_path('app/ocr');

        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0777, true);
        }

        $outputPattern = $outputDir . DIRECTORY_SEPARATOR . 'page-%03d.png';

        $ghostscript = '"C:\Program Files\gs\gs10.07.1\bin\gswin64c.exe"';

        $command = $ghostscript .
            ' -dNOPAUSE -dBATCH -sDEVICE=png16m -r150 ' .
            '-sOutputFile="' . $outputPattern . '" "' . $pdfPath . '"';

        exec($command, $output, $result);

        if ($result !== 0) {
            throw new \Exception('Failed to convert PDF.');
        }

        return glob($outputDir . DIRECTORY_SEPARATOR . '*.png');
    }


    public function extractTextFromImage(string $imagePath): string
    {
        $imageBase64 = base64_encode(file_get_contents($imagePath));

        $response = Http::timeout(600)->post(
            'http://localhost:11434/api/chat',
            [
                'model' => 'glm-ocr',
                'stream' => false,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => '
                            Extract ALL text from this document.

                            Rules:
                            - Do not summarize.
                            - Do not explain.
                            - Do not skip any text.
                            - Include headers, tables, numbers, and footer.
                            - Keep the original order of the text.
                            - Preserve line breaks.
                            - If text is unclear, try your best to read it.
                            - Return ONLY the extracted text.
                            ',
                        'images' => [$imageBase64],
                    ]
                ],
                'options' => [
                    'temperature' => 0,
                    'num_predict' => 4096,
                ]
            ]
        );

        if ($response->failed()) {
            throw new \Exception($response->body());
        }

        return $response->json()['message']['content'];
    }
}