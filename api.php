<?php 
session_start();
require_once("db/database.php");
function getNewTicketInfo(){
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
    $sql = "INSERT INTO tb_request (id,sub_pesan,deskripsi,level_prioritas,status) 
            VALUES('$ticket_id','$ticket_subject','$ticket_description','$ticket_priority','$ticket_status');";
    $result = $mysqli->query($sql);
}
function insertTicketResponder($ticket_id,$responder_id,$responder_type){
    global $mysqli;
    $sql = "INSERT INTO tb_perespon (id_req,id_perespon,tipe_perespon)
            VALUES('$ticket_id','$responder_id','$responder_type')";
    $mysqli->query($sql);

}
function inserTicketDetail($responder_id,$ticket_id,$respon_desc,$respon_type){
    global $mysqli;
    $sql = "CALL add_detail_respon($responder_id,'$ticket_id','$respon_desc','$respon_type');";
    $mysqli->query($sql);
}
function getTicketInfo( $ticket_id ){
    global $mysqli;
    $sql = "SELECT request.sub_pesan ,request.status ,request.created_at ,request.update_at ,request.level_prioritas FROM tb_request request WHERE request.id='$ticket_id'";
    $ticket = $mysqli->query($sql)->fetch_assoc();
    $sql = "SELECT pegawai.id,pegawai.nama as text FROM tb_perespon perespon LEFT JOIN tb_pegawai pegawai ON pegawai.id = perespon.id_perespon WHERE perespon.id_req = '$ticket_id';";
    $responder = $mysqli->query($sql)->fetch_all(MYSQLI_ASSOC);
    return array('ticket'=>$ticket,'responder'=>$responder);
}
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.php'>";
}else{
    $request = $_SERVER['REQUEST_URI'];
    switch ($request) {
        case '/api.php/newticketinfo':
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode(getNewTicketInfo());
            break;
        case '/api.php/new_ticket':
            // var_dump($_POST);
            $mysqli->begin_transaction();
            try {
                insertTicket($_POST['ticket_id'],$_POST['ticket_sub'],$_POST['ticket_desc'],$_POST['ticket_priority']);
                insertTicketResponder($_POST['ticket_id'],$_SESSION['id_user'],'creator');
                foreach($_POST['responders'] as $responder ) {
                    insertTicketResponder($_POST['ticket_id'],$responder,'responder');
                }
                $mysqli->commit();
                $response = array(
                    'status'=> 'success',
                    'message'=> 'Berhasil Insert'
                );
            } catch (Exception $exception) {
                $mysqli->rollback();
                $response = array(
                    'message'=> $exception->getMessage()
                );
            }
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode($response);
            break;
        case '/api.php/ticketinfo':
            $ticket_id=$_POST['ticket_id'];
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode(getTicketInfo($ticket_id));
            break;
    }
}
?>