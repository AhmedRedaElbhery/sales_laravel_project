<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class JsonService
{
    public function extractInvoiceData(string $text)
    {
        $prompt = <<<PROMPT
Extract this invoice into JSON.

Return ONLY valid JSON.

Use exactly this structure:

{
  "company_name": "",
  "company_phone": "",
  "company_address": "",
  "company_email": "",
  "auto_serial": "",

  "customer_name": "",
  "customer_phone": "",
  "customer_address": "",

  "items": [
    {
      "name": "",
      "unit": "",
      "quantity": "",
      "unit_price": "",
      "total": ""
    }
  ],
  "subtotal": "",
  "tax_rate": "",
  "discount_rate": "",
  "final_total": "",
  "paid": "",
  "remaining": "",
  "notes": ""
}

Rules:

Important:
- Invoice text may have labels and values separated by new lines.
- Always read the value after the label, even if it is on the next line.
- Do not ignore a field just because ":" is missing.

Company information:

- Extract "company Name" or "Company Name" as company_name.
- Extract "Phone" as company_phone.
- Extract "Address" as company_address.
- Extract "Email" as company_email.


Company/customer separation rules:

- The company information appears before customer information.
- "Phone" belongs to company_phone unless the label is exactly "Customer Phone".
- "Address" belongs to company_address unless the label is exactly "Customer Address".
- Never put company Address inside customer_address.
- Never put customer Address inside company_address.

Example:

Input:
Address : Cairo
Customer Address : Giza

Output:
{
  "company_address": "Cairo",
  "customer_address": "Giza"
}

Input:
Phone : 0123456789
Customer Phone :

Output:
{
  "company_phone": "0123456789",
  "customer_phone": ""
}


Customer information:

- Extract "Customer Name" as customer_name.
- Extract "Customer Phone" as customer_phone.
- Extract "Customer Address" as customer_address.
- Customer Address can continue on multiple lines until the next field label.


Invoice serial number:

- Extract the invoice number and store it in auto_serial.
- The invoice number usually appears after the word "INVOICE".
- Extract only the numeric value.
- Ignore spaces, new lines, ":" , "#" and "-" characters.

Examples:

Input:
INVOICE 1

Output:
{
  "auto_serial": "1"
}

Input:
Invoice No: 25

Output:
{
  "auto_serial": "25"
}

Input:
INVOICE
100

Output:
{
  "auto_serial": "100"
}

- If the invoice number does not exist, return an empty string.


Invoice totals:

- Extract "Sub Total" as subtotal.
- Extract "Tax Rate" as tax_rate.
- Extract only the number from tax_rate. Remove "%".
- Extract "Discount Rate" as discount_rate.
- Extract only the number from discount_rate. Remove "%".
- Extract "Total" as final_total.
- Extract "Paid" as paid.
- Extract "Remaining" as remaining.
- Extract "Notes" content as notes.
- Notes value can be on the next line.
- Notes can contain numbers.


Items:

The item columns are:

serial, name, unit, quantity, unit_price, total.

Rules:

- Ignore the serial number.
- The name and unit are ALWAYS separate fields.
- Never combine name and unit together.

Example:

Input:
1 ارز مربوطه 5 0 0

Output:

{
  "name": "ارز",
  "unit": "مربوطه",
  "quantity": "5",
  "unit_price": "0",
  "total": "0"
}

For every item row:

- Remove the first number (serial).
- First word after serial = name.
- Second word after serial = unit.
- Third value = quantity.
- Fourth value = unit_price.
- Last value = total.


Other rules:

- If a value does not exist, return an empty string.
- If there are no items, return an empty array.
- Do not invent information.
- Do not add extra fields.
- Keep the exact JSON structure.
- Return ONLY valid JSON.


Invoice text:

$text
PROMPT;


        $response = Http::timeout(300)->post(
            'http://127.0.0.1:11434/api/generate',
            [
                'model' => 'qwen3.5:4b',
                'prompt' => $prompt,
                'stream' => false,
                'think' => false,
                'format' => 'json',
                'options' => [
                    'temperature' => 0,
                ],
            ]
        );


        if (! $response->successful()) {
            throw new \Exception('Ollama request failed: ' . $response->body());
        }


        $data = $response->json();

        return json_decode($data['response'], true);
    }
}