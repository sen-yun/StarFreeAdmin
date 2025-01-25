<?php
include_once 'connect.php';
$dataType = isset($_GET['dataType']) ? $_GET['dataType'] : '';
if ($dataType === 'registrations') {
    $days = isset($_GET['days']) ? intval($_GET['days']) : 7;
    $days = min(max($days, 1), 180);
    
    $data = array(
        'dates' => array(),
        'counts' => array()
    );
    
    $end_date = date('Y-m-d');
    $start_date = date('Y-m-d', strtotime("-$days days"));
    
    $sql = "SELECT DATE(FROM_UNIXTIME(created)) as date, COUNT(*) as count 
            FROM ".$db_prefix."_users 
            WHERE DATE(FROM_UNIXTIME(created)) BETWEEN ? AND ?
            GROUP BY date 
            ORDER BY date ASC";
            
    $stmt = $connect->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('ss', $start_date, $end_date);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $current = strtotime($start_date);
        $end = strtotime($end_date);
        
        while ($current <= $end) {
            $date = date('Y-m-d', $current);
            $data['dates'][] = date('m-d', $current);
            $data['counts'][] = 0;
            $current = strtotime('+1 day', $current);
        }
        
        while ($row = $result->fetch_assoc()) {
            $index = array_search(date('m-d', strtotime($row['date'])), $data['dates']);
            if ($index !== false) {
                $data['counts'][$index] = intval($row['count']);
            }
        }
        
        $stmt->close();
    }
    
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

$connect->close();
?>