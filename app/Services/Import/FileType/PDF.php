<?php

namespace App\Services\Import\FileType;

use App\Services\Book\Builder\Classes\Book;
use Illuminate\Support\Facades\Log;
use Mpdf\Mpdf;
use Mpdf\MpdfException;

class PDF implements FileTypeInterface
{
    const FILE_TYPE = 'pdf';

    /**
     * @throws MpdfException
     */
    public function save(Book &$book): bool
    {
        $mpdf = new Mpdf([
            'default_font_size' => 10,
            'mode' => 'utf-8',
            'format' => 'A4',
        ]);

        $mpdf->setFooter('{PAGENO}');
        $mpdf->SetHTMLFooter('<div style="text-align: center">- {PAGENO} -</div>');

        foreach ($book->context as $index => $page) {
            if ($index === 0) {
                $mpdf->WriteHTML('<p style="align-content: center; font-size: 16px; font-style: oblique; vertical-align: center">' . $book->title . '</p><hr>');
            }

            foreach ($page as $line) {
                $mpdf->WriteHTML($line);
            }
        }

        $book->pages = $mpdf->page;

        try {
            $mpdf->Output(public_path('/storage/' . $book->filename . '.pdf'),'F');

            return true;
        } catch (\Exception $e) {
            Log::critical(__METHOD__, [__LINE__ => $e->getMessage()]);
        }

        return false;
    }
}
