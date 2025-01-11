<?php
require '../../public/app.php'; // Koneksi ke database
require '../../public/fpdf/fpdf.php'; // Library FPDF

// Ambil data berdasarkan id_tanggapan
$id_tanggapan = $_GET['id_tanggapan'];
$query = "SELECT * FROM ((tanggapan INNER JOIN pengaduan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan)
          INNER JOIN petugas ON tanggapan.id_petugas = petugas.id_petugas)
          WHERE id_tanggapan = $id_tanggapan";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Inisialisasi PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Header
$pdf->Cell(0, 10, 'Laporan Tanggapan', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Ln(10);

// Isi Laporan
$pdf->Cell(50, 10, 'NIK:', 0, 0);
$pdf->Cell(0, 10, $data['nik'], 0, 1);

$pdf->Cell(50, 10, 'Nama Petugas:', 0, 0);
$pdf->Cell(0, 10, $data['nama_petugas'], 0, 1);

$pdf->Cell(50, 10, 'Tanggal Pengaduan:', 0, 0);
$pdf->Cell(0, 10, $data['tgl_pengaduan'], 0, 1);

$pdf->Cell(50, 10, 'Tanggal Tanggapan:', 0, 0);
$pdf->Cell(0, 10, $data['tgl_tanggapan'], 0, 1);

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Isi Laporan', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, $data['isi_laporan']);

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Isi Tanggapan', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, $data['tanggapan']);

// Output PDF
$pdf->Output('I', 'Laporan_Tanggapan.pdf');
