<?php 
session_start();
require_once("db/database.php");
function getTicketInfo(){
    global $mysqli;
    $sql = "SELECT RIGHT(request.id,3) as id  FROM tb_request request ORDER BY id DESC LIMIT 1;";
    $result = $mysqli->query($sql);
    $ticket_id = "REQ".str_pad($result->fetch_assoc()['id']+1,3,'0',STR_PAD_LEFT);
    $sql = "SELECT  pegawai.id,pegawai.nama as text  FROM tb_pegawai pegawai";
    $result = $mysqli->query($sql);
    $items = $result->fetch_all(MYSQLI_ASSOC);
    return array("ticket_id"=>$ticket_id,"items"=>$items);
}
function insertTicket($ticket_id,$ticket_subject,$ticket_description,$ticket_priority){
    global $mysqli;
    $ticket_status = "waiting";
    $ticket_subject=trim($ticket_subject);
    $sql = "INSERT INTO tb_request (id,sub_pesan,deskripsi,level_prioritas,status_id) 
            VALUES('$ticket_id','$ticket_subject','$ticket_description','$ticket_priority','$ticket_status');";
    $result = $mysqli->query($sql);
}
function insertTicketResponder($ticket_id,$responder_id,$responder_type){
    global $mysqli;
    $sql = "INSERT INTO tb_perespon (id_req,id_perespon,tipe)
            VALUES('$ticket_id','$responder_id','$responder_type')";

}
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.php'>";
}else{
    $request = $_SERVER['REQUEST_URI'];
    switch ($request) {
        case '/api.php/ticketinfo':
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode(getTicketInfo());
            break;
        case '/api.php/new_ticket':
            var_dump($_POST);
            // $mysqli->begin_transaction();
            // try {
            //     insertTicket($_POST['ticket_id'],$_POST['ticket_sub'],$_POST['ticket_desc'],$_POST['ticket_priority']);
            //     insertTicketResponder($_POST['ticket_id'],$_SESSION['id_user'],'creator');
            //     foreach($_POST['responders'] as $responder ) {
            //         insertTicketResponder($_POST['ticket_id'],$responder,'responder');
            //     }
            //     $mysqli->commit();
            // } catch (Exception $exception) {
            //     $mysqli->rollback();
            // }
            // http_response_code(200);
    }
}
?>