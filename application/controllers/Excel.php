<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel extends CI_Controller
{
    public function index()
    {
        $file = './files/test.xlsx';

        // Load library PHPExcel
        $this->load->library('excel');

        // // Buat object PHPExcel
        // $objPHPExcel = new PHPExcel();

        // // Set sheet yang akan diolah
        // $objPHPExcel->setActiveSheetIndex(0)
        //             ->setCellValue('A1', 'Hello')
        //             ->setCellValue('B1', 'Ini')
        //             ->setCellValue('C1', 'Excel')
        //             ->setCellValue('D2', 'Pertamaku');

        // // set title pada sheet
        // $objPHPExcel->getActiveSheet()->setTitle('Excel Pertama');

        // // mulai menyimpan excel format xlsx, kalau ingin xls ganti ke Excel2007 menjadi Excel5
        // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        // // Sesuaikan headernya
        // header("Last-Modified: " . gmdate('D, d M Y H:i:s') . "GMT");
        // header("Cache-Control: no-store, no-cache, must-revalidate");
        // header("Cache-Control: post-check=0, pre-check=0", false);
        // header("Pragma: no-cache");
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        // // Ubah nama file yang diunduh
        // header('Content-Disposition: attachment;filename="hasilExcel.xlsx"');

        // // Unduh file
        // $objWriter->save("php://output");

        // $objPHPExcel = PHPExcel_IOFactory::load($file);

        // $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        // foreach ($cell_collection as $cell) {
        //     $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
        //     $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
        //     $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
        //     //header will/should be in row 1 only. of course this can be modified to suit your need.
        //     if ($row == 1) {
        //         $header[$row][$column] = $data_value;
        //     } else {
        //         $arr_data[$row][$column] = $data_value;
        //     }
        // }

        // $data['header'] = $header;
        // $data['values'] = $arr_data;

        // $data = array(1,2,3,4,5);
    }
}