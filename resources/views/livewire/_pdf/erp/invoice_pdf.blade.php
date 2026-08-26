<?php

use Livewire\Volt\Component;

new class extends Component {
     $pdf = Pdf::view('_pdf.test_pdf', [
            'company' => (object)array(
                'logo' => $this->company_logo,
                'name' => $this->company_name,
                'address' => $this->company_address,
                'email' => $this->company_email
            ),
            'document' => (object)array(
                'title' => $this->document_title,
                'date' => date('d-m-Y'),
                'reference' => 'INV-001-26'
            ),
            'file' => (object)array(
                'name' => 'Test PDF',
                'path' => 'img/test.pdf'
            ),
        ]);

        $pdf->format('a4');
        $pdf->margins(0, 5, 5, 5);
}; ?>

<div>
    <head>
        <style>
            body {
                margin: 0;
                padding: 0 20px;
                font-size: 10px;
                font-family: Arial, sans-serif;
                color: #555;
            }

            .header {
                width: 100%;
                border-bottom: 1px solid #ccc;
                padding-bottom: 5px;
            }

            .left {
                float: left;
            }

            .right {
                text-align: right;
            }

            /* Company */
            .company {
                text-align: right;
            }

            .company_name {
                font-size: 25px;
                font-weight: bold;
            }

            /* Document */
            .document_title {
                font-size: 20px;
                font-weight: bold;
                text-transform: uppercase;
            }

            .document_date {
                font-size: 15px;
            }

            .document_reference {
                font-size: 15px;
                font-style: italic;
                color: grey;
                font-weight: bold;
            }

            .logo {
                border-radius: 4px;
                height: 50px;
                width: 70px;
                aspect-ratio: 1/1;
            }
        </style>
        <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
    </head>

    <body>
        <div class="header">
            <table style="width: 95%;">
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td>
                                    <div class="logo">
                                        @inlinedImage('img/logo.png')
                                    </div>
                                    {{-- <img src="" style="width:70px;height:auto;"> --}}
                                </td>
                                <td>
                                    <h3 class="company_name"> {{ $company->name }}</h3>

                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <div class="company">
                            <div class="document_title"> {{ $document->title }}</div>
                            <div class="document_date">{{ $document->date }}</div>
                            <div class="document_reference">{{ $document->reference }}</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

    </body>

</div>
