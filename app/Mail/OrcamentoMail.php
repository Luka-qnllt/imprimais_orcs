<?php

namespace App\Mail;

use App\Http\Controllers\PdfController;
use App\Models\Orcamento;
use App\Services\ParametrosService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class OrcamentoMail extends Mailable
{
    use Queueable, SerializesModels;

    private $data;
    private $orcamento;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Orcamento $orcamento, array $data)
    {
        $this->orcamento = $orcamento;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdfService = new PdfController;
        $pdfOrc = $pdfService->generatePdf($this->orcamento);

        $anexName = '/temp/Orcamento_' . str_replace(' ', '_', $this->orcamento->solicitante) . '_' . date('d_m_Y_H_i_s') . '.pdf';

        $savedFile = Storage::disk('public')->put($anexName, $pdfOrc);
        if(empty($savedFile)){
            throw new Exception('Erro ao gerar PDF para anexo');
        }

        $this->subject('Orçamento Imprimais Digital');
        $this->to($this->data['email'], '');
        $this->attach(storage_path('app/public') . $anexName);

        // if(is_file(storage_path('app/public') . $anexName)){
        //     unlink(storage_path('app/public') . $anexName);
        // }

        $parametrosService = new ParametrosService;
        $parametros = $parametrosService->formatParams();

        return $this->view('archives.email-orcamento', [ 'data' => $this->data, 'params' => $parametros ]);
    }
}
