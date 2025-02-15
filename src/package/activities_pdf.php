<?php
require __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../../fpdf/fpdf.php';
require_once 'activities.php';

if (is_post_request()) {
    check_csrf_token();
    $activities = [];
    $activityId = $_POST['activity_id'];
    if($activityId){
        $activity = retrieveActivityById($activityId);
        if ($activity) {
            $activities[] = $activity;
        }
    }

    if (empty($activities)) {
        $activities = retrieveActivities();
    }

    generate_activities_pdf($activities);
}

function generate_activities_pdf($activities): void

{
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    $pdf->Cell(0, 10, 'Our offer', 0, 1, 'C');

    foreach ($activities as $activity) {
        $pdf->Cell(0, 10, 'Service: ' . $activity['name'], 0, 1);
        $pdf->Cell(0, 10, 'Description: ' . $activity['description'], 0, 1);
        $pdf->Cell(0, 10, 'Price: $' . $activity['price'], 0, 1);
        $wrappedText = wordwrap($activity['info'], 60, "\n", true);
        $pdf->MultiCell(0, 10, 'More info: ' . $wrappedText);


        $pdf->Ln();
    }

    $pdf->Output('activities_list.pdf', 'D');
}
