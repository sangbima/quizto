<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();

        // $batas_pendaftaran = date('2017-04-20 16:00:00');
        $now = date('Y-m-d H:i:s', time());
        // $now = date('2017-04-20 23:59:59');
        
        if($now >= date($this->config->item('batas_pendaftaran'))) {
            redirect('login');
        }

        if($this->session->userdata('logged_in')){
            redirect('dashboard');
        }

        $this->load->database();
        $this->load->model("register_model");
        $this->load->model("provinsi_model");
        $this->load->model("kotakabupaten_model");
        $this->load->library('email');
        $this->load->helper(array('form', 'url', 'file'));
        $this->load->library('form_validation');
        $this->lang->load('basic', $this->config->item('language'));
    }

    public function index()
    {
        $data['title'] = 'Register';
        $data['provinsi'] = $this->provinsi_model->get();
        // var_dump($data['provinsi']);die();
        $this->load->view('header',$data);
        $this->load->view('register_new',$data);    
        $this->load->view('footer',$data);
    }

    public function submit()
    {
        $this->form_validation->set_rules('first_name', 'Nama Depan', 'required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[register.email]');
        $this->form_validation->set_rules('nik', 'NIK', 'is_natural|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('desakelurahan', 'Desa/Kelurahan', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        $this->form_validation->set_rules('kabupatenkota', 'Kabupaten/Kota', 'required');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
        $this->form_validation->set_rules('contact_no', 'Nomor Telepon', 'is_natural|required');
        $this->form_validation->set_rules('pendidikan', 'Tingkat Pendidikan', 'required');
        $this->form_validation->set_rules('institusi_pendidikan', 'Institusi Pendidikan', 'required');
        $this->form_validation->set_rules('fakultas', 'Fakultas/Jurusan', 'required');
        $this->form_validation->set_rules('no_ijazah', 'No. Ijazah', 'required');
        $this->form_validation->set_rules('nilai_ipk', 'IPK/NEM', 'decimal|required');
        $this->form_validation->set_rules('jobdesk', 'Deskripsi Pekerjaan', 'trim');
        $this->form_validation->set_rules('thn_mengabdi', 'Masa Kerja', 'decimal');
        
        $this->form_validation->set_rules('lampiran0', 'Pas Foto', 'callback_file_lampiran0_check');
        $this->form_validation->set_rules('lampiran1', 'Ijazah', 'callback_file_lampiran1_check');
        $this->form_validation->set_rules('lampiran2', 'KTP', 'callback_file_lampiran3_check');
        $this->form_validation->set_rules('lampiran3', 'Surat Pernyataan', 'callback_file_lampiran4_check'); 
        $this->form_validation->set_rules('lampiran4', 'Transkrip Nilai', 'callback_file_lampiran2_check');
        $this->form_validation->set_rules('lampiran5', 'Daftar Riwayat Hidup', 'callback_file_lampiran5_check');
        $this->form_validation->set_rules('lampiran6', 'Surat Lamaran', 'callback_file_lampiran6_check');
        $this->form_validation->set_rules('lampiran7', 'SKCK', 'callback_file_lampiran7_check');
        $this->form_validation->set_rules('lampiran8', 'SKSJ', 'callback_file_lampiran8_check');
        $this->form_validation->set_rules('lampiran9', 'BPJS/KIS', 'callback_file_lampiran9_check');
        
        $this->form_validation->set_message('required', 'Input %s wajib diisi.');
        $this->form_validation->set_message('min_length', 'Input %s sekurangnya harus berisi %s karakter.');
        $this->form_validation->set_message('valid_email', 'Input %s harus berisi alamat email yang valid');
        $this->form_validation->set_message('is_unique', '%s ini sudah terdaftar');
        $this->form_validation->set_message('matches', 'Input %s tidak sama dengan input password sebelumnya');
        $this->form_validation->set_message('numeric', 'Input %s harus berupa angka');
        $this->form_validation->set_message('required', 'Input %s wajib diisi.');
        $this->form_validation->set_message('files_required', 'Dokumen %s wajib diisi.');
        $this->form_validation->set_message('document_upload', "File %s harus berupa file *.doc, *.docx atau *.pdf");
        $this->form_validation->set_message('gambar_upload', "File foto/scan %s harus berupa file *.jpg atau *.jpeg");
        $this->form_validation->set_message('ukuran_file', "File maksimal berukuran 200KB");

        if($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo $errors;
        } else {
            if($this->register_model->insertdata()) {
                echo "YES";
            } else {
                echo "NO";
            }
        }
    }

    public function file_lampiran0_check($str)
    {
        // Berupa image
        $allowed_mime_type_arr = array('image/jpeg');
        $mime = get_mime_by_extension($_FILES['lampiran0']['name']);
        if(isset($_FILES['lampiran0']['name']) && $_FILES['lampiran0']['name'] != '') {
            if(in_array($mime, $allowed_mime_type_arr)) {
                if($_FILES['lampiran0']['size'] < 204800) {
                    return true;
                } else {
                    $this->form_validation->set_message('file_lampiran0_check', 'Foto harus berukuran maksimal 200KB');
                    return false;
                }
            } else {
                $this->form_validation->set_message('file_lampiran0_check', 'Foto harus berupa file .jpg atau .jpeg');
                return false;
            }
        } else {
            $this->form_validation->set_message('file_lampiran0_check', 'Foto harus diunggah');
            return false;
        }
    }

    public function file_lampiran1_check($str)
    {
        // Berupa image
        $allowed_mime_type_arr = array('image/jpeg');
        $mime = get_mime_by_extension($_FILES['lampiran1']['name']);
        if(isset($_FILES['lampiran1']['name']) && $_FILES['lampiran1']['name'] != '') {
            if(in_array($mime, $allowed_mime_type_arr)) {
                if($_FILES['lampiran1']['size'] < 204800) {
                    return true;
                } else {
                    $this->form_validation->set_message('file_lampiran1_check', 'Ijazah harus berukuran maksimal 200KB');
                    return false;
                }
            } else {
                $this->form_validation->set_message('file_lampiran1_check', 'Ijazah harus berupa file .jpg atau .jpeg');
                return false;
            }
        } else {
            $this->form_validation->set_message('file_lampiran1_check', 'Ijazah harus diunggah');
            return false;
        }
    }

    // public function file_lampiran2_check($str)
    // {
    //     // Berupa image
    //     $allowed_mime_type_arr = array('image/jpeg');
    //     $mime = get_mime_by_extension($_FILES['lampiran2']['name']);
    //     if(isset($_FILES['lampiran2']['name']) && $_FILES['lampiran2']['name'] != '') {
    //         if(in_array($mime, $allowed_mime_type_arr)) {
    //             if($_FILES['lampiran2']['size'] < 204800) {
    //                 return true;
    //             } else {
    //                 $this->form_validation->set_message('file_lampiran2_check', 'Transkrip Nilai harus berukuran maksimal 200KB');
    //                 return false;
    //             }
    //         } else {
    //             $this->form_validation->set_message('file_lampiran2_check', 'Transkrip Nilai harus berupa file .jpg atau .jpeg');
    //             return false;
    //         }
    //     } else {
    //         $this->form_validation->set_message('file_lampiran2_check', 'Transkrip Nilai harus diunggah');
    //         return false;
    //     }
    // }

    public function file_lampiran2_check($str)
    {
        // Berupa Dokumen
        $allowed_mime_type_arr = array('application/pdf');
        $mime = get_mime_by_extension($_FILES['lampiran4']['name']);
        if(isset($_FILES['lampiran4']['name']) && $_FILES['lampiran4']['name'] != '') {
            if(in_array($mime, $allowed_mime_type_arr)) {
                if($_FILES['lampiran4']['size'] < 204800) {
                    return true;
                } else {
                    $this->form_validation->set_message('file_lampiran2_check', 'Transkrip Nilai harus berukuran maksimal 200KB');
                return false;
                }
            } else {
                $this->form_validation->set_message('file_lampiran2_check', 'Transkrip Nilai harus berupa file .pdf');
                return false;
            }
        } else {
            $this->form_validation->set_message('file_lampiran2_check', 'Transkrip Nilai harus diunggah');
            return false;
        }
    }

    public function file_lampiran3_check($str)
    {
        // Berupa image
        $allowed_mime_type_arr = array('image/jpeg');
        $mime = get_mime_by_extension($_FILES['lampiran3']['name']);
        if(isset($_FILES['lampiran3']['name']) && $_FILES['lampiran3']['name'] != '') {
            if(in_array($mime, $allowed_mime_type_arr)) {
                if($_FILES['lampiran3']['size'] < 204800) {
                    return true;
                } else {
                    $this->form_validation->set_message('file_lampiran3_check', 'KTP harus berukuran maksimal 200KB');
                    return false;
                }
            } else {
                $this->form_validation->set_message('file_lampiran3_check', 'KTP harus berupa file .jpg atau .jpeg');
                return false;
            }
        } else {
            $this->form_validation->set_message('file_lampiran3_check', 'KTP harus diunggah');
            return false;
        }
    }

    public function file_lampiran4_check($str)
    {
        // Berupa image
        $allowed_mime_type_arr = array('image/jpeg');
        $mime = get_mime_by_extension($_FILES['lampiran3']['name']);
        if(isset($_FILES['lampiran3']['name']) && $_FILES['lampiran3']['name'] != '') {
            if(in_array($mime, $allowed_mime_type_arr)) {
                if($_FILES['lampiran3']['size'] < 204800) {
                    return true;
                } else {
                    $this->form_validation->set_message('file_lampiran4_check', 'Surat Pernyataan harus berukuran maksimal 200KB');
                    return false;
                }
            } else {
                $this->form_validation->set_message('file_lampiran4_check', 'Surat Pernyataan harus berupa file .jpg atau .jpeg');
                return false;
            }
        } else {
            $this->form_validation->set_message('file_lampiran4_check', 'Surat Pernyataan harus diunggah');
            return false;
        }
    }

    // public function file_lampiran5_check($str)
    // {
    //     // Berupa Dokumen
    //     $allowed_mime_type_arr = array('application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    //     $mime = get_mime_by_extension($_FILES['lampiran5']['name']);
    //     if(isset($_FILES['lampiran5']['name']) && $_FILES['lampiran5']['name'] != '') {
    //         if(in_array($mime, $allowed_mime_type_arr)) {
    //             if($_FILES['lampiran5']['size'] < 204800) {
    //                 return true;
    //             } else {
    //                 $this->form_validation->set_message('file_lampiran5_check', 'Daftar Riwayat Hidup harus berukuran maksimal 200KB');
    //             return false;
    //             }
    //         } else {
    //             $this->form_validation->set_message('file_lampiran5_check', 'Daftar Riwayat Hidup harus berupa file .doc, .docx atau .pdf');
    //             return false;
    //         }
    //     } else {
    //         $this->form_validation->set_message('file_lampiran5_check', 'Daftar Riwayat Hidup harus diunggah');
    //         return false;
    //     }
    // }

    public function file_lampiran5_check($str)
    {
        // Berupa image
        $allowed_mime_type_arr = array('image/jpeg');
        $mime = get_mime_by_extension($_FILES['lampiran5']['name']);
        if(isset($_FILES['lampiran5']['name']) && $_FILES['lampiran5']['name'] != '') {
            if(in_array($mime, $allowed_mime_type_arr)) {
                if($_FILES['lampiran5']['size'] < 204800) {
                    return true;
                } else {
                    $this->form_validation->set_message('file_lampiran5_check', 'Daftar Riwayat Hidup harus berukuran maksimal 200KB');
                    return false;
                }
            } else {
                $this->form_validation->set_message('file_lampiran5_check', 'Daftar Riwayat Hidup harus berupa file .jpg atau .jpeg');
                return false;
            }
        } else {
            $this->form_validation->set_message('file_lampiran5_check', 'Daftar Riwayat Hidup harus diunggah');
            return false;
        }
    }

    // public function file_lampiran6_check($str)
    // {
    //     // Berupa dokumen
    //     $allowed_mime_type_arr = array('application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    //     $mime = get_mime_by_extension($_FILES['lampiran6']['name']);
    //     if(isset($_FILES['lampiran6']['name']) && $_FILES['lampiran6']['name'] != '') {
    //         if(in_array($mime, $allowed_mime_type_arr)) {
    //             if($_FILES['lampiran6']['size'] < 204800) {
    //                 return true;
    //             } else {
    //                 $this->form_validation->set_message('file_lampiran6_check', 'Surat Lamaran harus berupa file .doc, .docx atau .pdf');
    //             }
    //         } else {
    //             $this->form_validation->set_message('file_lampiran6_check', 'Surat Lamaran harus berukuran maksimal 200KB');
    //             return false;
    //         }
    //     } else {
    //         $this->form_validation->set_message('file_lampiran6_check', 'Surat Lamaran harus diunggah');
    //         return false;
    //     }
    // }

    public function file_lampiran6_check($str)
    {
        // Berupa image
        $allowed_mime_type_arr = array('image/jpeg');
        $mime = get_mime_by_extension($_FILES['lampiran6']['name']);
        if(isset($_FILES['lampiran6']['name']) && $_FILES['lampiran6']['name'] != '') {
            if(in_array($mime, $allowed_mime_type_arr)) {
                if($_FILES['lampiran6']['size'] < 204800) {
                    return true;
                } else {
                    $this->form_validation->set_message('file_lampiran6_check', 'Surat Lamaran harus berukuran maksimal 200KB');
                    return false;
                }
            } else {
                $this->form_validation->set_message('file_lampiran6_check', 'Surat Lamaran harus berupa file .jpg atau .jpeg');
                return false;
            }
        } else {
            $this->form_validation->set_message('file_lampiran6_check', 'Surat Lamaran harus diunggah');
            return false;
        }
    }

    public function file_lampiran7_check($str)
    {
        // Berupa image
        $allowed_mime_type_arr = array('image/jpeg');
        $mime = get_mime_by_extension($_FILES['lampiran7']['name']);
        if(isset($_FILES['lampiran7']['name']) && $_FILES['lampiran7']['name'] != '') {
            if(in_array($mime, $allowed_mime_type_arr)) {
                if($_FILES['lampiran7']['size'] < 204800) {
                    return true;
                } else {
                    $this->form_validation->set_message('file_lampiran7_check', 'Surat Keterangan Catatan Kepolisian maksimal 200KB');
                    return false;
                }
            } else {
                $this->form_validation->set_message('file_lampiran7_check', 'Surat Keterangan Catatan Kepolisian harus berupa file .jpg atau .jpeg');
                return false;
            }
        } else {
            $this->form_validation->set_message('file_lampiran7_check', 'Surat Keterangan Catatan Kepolisian harus diunggah');
            return false;
        }
    }

    public function file_lampiran8_check($str)
    {
        // Berupa image
        $allowed_mime_type_arr = array('image/jpeg');
        $mime = get_mime_by_extension($_FILES['lampiran8']['name']);
        if(isset($_FILES['lampiran8']['name']) && $_FILES['lampiran8']['name'] != '') {
            if(in_array($mime, $allowed_mime_type_arr)) {
                if($_FILES['lampiran8']['size'] < 204800) {
                    return true;
                } else {
                    $this->form_validation->set_message('file_lampiran8_check', 'Surat Keterangan Sehat Jasmani maksimal 200KB');
                    return false;
                }
            } else {
                $this->form_validation->set_message('file_lampiran8_check', 'Surat Keterangan Sehat Jasmani harus berupa file .jpg atau .jpeg');
                return false;
            }
        } else {
            $this->form_validation->set_message('file_lampiran8_check', 'Surat Keterangan Sehat Jasmani harus diunggah');
            return false;
        }
    }

    public function file_lampiran9_check($str)
    {
        // Berupa image
        $allowed_mime_type_arr = array('image/jpeg');
        $mime = get_mime_by_extension($_FILES['lampiran9']['name']);
        if(isset($_FILES['lampiran9']['name']) && $_FILES['lampiran9']['name'] != '') {
            if(in_array($mime, $allowed_mime_type_arr)) {
                if($_FILES['lampiran9']['size'] < 204800) {
                    return true;
                } else {
                    $this->form_validation->set_message('file_lampiran9_check', 'BPJS/KIS maksimal 200KB');
                    return false;
                }
            } else {
                $this->form_validation->set_message('file_lampiran9_check', 'BPJS/KIS harus berupa file .jpg atau .jpeg');
                return false;
            }
        } else {
            $this->form_validation->set_message('file_lampiran9_check', 'BPJS/KIS harus diunggah');
            return false;
        }
    }

    public function reg()
    {
        redirect('register/success');
    }

    public function success()
    {
        $data['title'] = 'Register Success';
        $this->load->view('header',$data);
        $this->load->view('register_success',$data);
        $this->load->view('footer',$data);
    }

    public function getkotabyprovinsi($provinsi)
    {
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($this->kotakabupaten_model->get_kotakabupaten_by_provinsi(urldecode($provinsi))));
    }

    public function test()
    {
        // $this->load->library('email');

        // if($this->config->item('protocol')=="smtp"){
        //     $config = array();
        //     $config['protocol'] = 'smtp';
        //     $config['smtp_host'] = $this->config->item('smtp_hostname');
        //     $config['smtp_user'] = $this->config->item('smtp_username');
        //     $config['smtp_pass'] = $this->config->item('smtp_password');
        //     $config['smtp_port'] = $this->config->item('smtp_port');
        //     $config['smtp_timeout'] = $this->config->item('smtp_timeout');
        //     $config['mailtype'] = $this->config->item('smtp_mailtype');
        //     $config['starttls']  = $this->config->item('starttls');
        //     $config['newline']  = $this->config->item('newline');
            
        //     $this->email->initialize($config);
        // }
        
        // $fromemail = $this->config->item('fromemail');
        // $fromname = $this->config->item('fromname');
        // $subject = $this->config->item('email_subject');
        // $message = $this->config->item('email_message');
        
        // $message = str_replace('[registration_no]', $this->register_model->generateRegistrationNumber(), $message);
        // $message = str_replace('[password]', 'inipassword', $message);

        // $toemail = 'sangbima.net@gmail.com';

        // $this->email->to($toemail);
        // $this->email->from($fromemail, $fromname);
        // $this->email->subject($subject);
        // $this->email->message($message);
        // if(!$this->email->send()){
        //     print_r($this->email->print_debugger());
        //     exit;
        // }  
    }
}