<?php
// Include TCPDF library
require_once('tcpdf/tcpdf.php');

// Include database connection
include 'db_connection.php';

class PDFReportGenerator {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function generatePDFReport($title, $header, $data) {
        // Create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle($title);
        $pdf->SetSubject('Report');
        $pdf->SetKeywords('TCPDF, PDF, report');

        // Set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' Report', PDF_HEADER_STRING);

        // Set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // Set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // Set font
        $pdf->SetFont('dejavusans', '', 10);

        // Add a page
        $pdf->AddPage();

        // Set title with date and type created on the top right corner
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, $title, 0, 1, 'R'); // Title
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 10, 'Created on: ' . date('Y-m-d H:i:s') . ' | Type: ' . $title, 0, 1, 'R'); // Date and type created

        // Set content to print
        $html = '<br><br>';
        $html .= '<table border="1"><thead><tr>';
        foreach ($header as $heading) {
            $html .= '<th>'.$heading.'</th>';
        }
        $html .= '</tr></thead><tbody>';
        foreach ($data as $row) {
            $html .= '<tr>';
            foreach ($row as $key => $cell) {
                if ($key === 'main_image') {
                    // Display image as <img> tag
                    $html .= '<td><img src="'.$cell.'" alt="Image" style="max-width: 100px; max-height: 100px;"></td>';
                } else {
                    $html .= '<td>'.$cell.'</td>';
                }
            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';

        // Print content
        $pdf->writeHTML($html, true, false, true, false, '');

        // Close and output PDF document
        $pdf->Output('report.pdf', 'D');
    }
}

// Function to fetch data for Products Report
function fetchProductsData($conn) {
    $data = array();
    $sql = "SELECT product_id, name, description, total_quantity, status FROM products";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// Function to fetch data for Raw Materials Report
function fetchRawMaterialsData($conn) {
    $data = array();
    $sql = "SELECT raw_material_id, name, description, total_quantity, status FROM raw_materials";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// Function to fetch data for Purchase Orders Report
function fetchPurchaseOrdersData($conn) {
    $data = array();
    $sql = "SELECT order_id, client_id, status, delivery_reference, created_on FROM orders";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// Check which report to generate
if (isset($_GET['report'])) {
    $reportType = $_GET['report'];
    $pdfGenerator = new PDFReportGenerator($conn);
    switch ($reportType) {
        case 'products':
            $title = 'Products Report';
            $header = array('Product ID', 'Name', 'Description', 'Total Quantity', 'Status');
            $data = fetchProductsData($conn);
            $pdfGenerator->generatePDFReport($title, $header, $data);
            break;
        case 'raw_materials':
            $title = 'Raw Materials Report';
            $header = array('Raw Material ID', 'Name', 'Description', 'Total Quantity', 'Status');
            $data = fetchRawMaterialsData($conn);
            $pdfGenerator->generatePDFReport($title, $header, $data);
            break;
        case 'purchase_orders':
            $title = 'Purchase Orders Report';
            $header = array('Order ID', 'Client ID', 'Status', 'Delivery Reference', 'Created On');
            $data = fetchPurchaseOrdersData($conn);
            $pdfGenerator->generatePDFReport($title, $header, $data);
            break;
        default:
            echo 'Invalid report type';
            break;
    }
} else {
    echo 'Report type not specified';
}

// Close connection
$conn->close();
?>
