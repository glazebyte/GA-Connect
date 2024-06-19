<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Kirim Ticket</h1>
            </div>
            <div class="col-sm-6">
            </div>
        </div>
    </div>
</section>
<section class="content">


    <!-- The Modal -->
    <div class="modal fade" id="requestModal">
        <form id="ticket_form" method="post" action="api.php/new_ticket">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Buat Ticket</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <!-- tb_request Fields -->
                        <h5>Ticket Information</h5>
                        <div class="form-group">
                            <label for="ticket_id">Ticket ID</label>
                            <input type="text" class="form-control" id="ticket_id" name="ticket_id" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="ticket_sub">Subject</label>
                            <input type="text" class="form-control" id="ticket_sub" name="ticket_sub" required>
                        </div>
                        <div class="form-group">
                            <label for="responders">Responder</label>
                            <select class="form-control" id="responder_select" name="responders[]" multiple="multiple" required>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editor">Deskripsi</label>
                            <div id="toolbar-container"></div>
                            <div id="editor1"></div>
                        </div>
                        <div class="form-group">
                            <label for="ticket_priority">Priority Level</label>
                            <select class="form-control" id="ticket_priority" name="ticket_priority" required>
                                <option value="low">Low</option>
                                <option value="mid">Mid</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </form>
    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data ticketing yg terkirim</h3>
                        <button type="button" id="add_ticket" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#requestModal">
                            Buat Ticket
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="datatables1" class="table table-bordered table-hover dataTable dtr-inline">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="center">No.</th>
                                                <th width="12%" class="center">ID Ticket</th>
                                                <th width="10%" class="center">Tanggal Pembuatan</th>
                                                <th width="13%" class="center">Pengirim</th>
                                                <th width="5%" class="center">Bidang</th>
                                                <th width="1%" class="center">Kordinator</th>
                                                <th width="20%" class="center">Subjek</th>
                                                <th width="10%" class="center">Prioritas</th>
                                                <th width="10%" class="center">Tanggal Diperrbarui</th>
                                                <th width="5%" class="center">Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            $sql = "SELECT request.id,request.sub_pesan ,request.level_prioritas ,request.status ,request.created_at ,request.update_at ,
                                                        GROUP_CONCAT( IF(perespon.tipe_perespon='creator',pegawai.nama,NULL))AS creator,                         
                                                        GROUP_CONCAT( IF(perespon.tipe_perespon='creator',pegawai.bidang,NULL))AS bidang_creator,
                                                        GROUP_CONCAT( IF(perespon.tipe_perespon='cordinator',pegawai.nama,NULL) )as cordinator
                                                        FROM tb_request request
                                                        LEFT JOIN tb_perespon perespon ON perespon.id_req = request.id 
                                                        LEFT JOIN tb_pegawai pegawai ON perespon.id_perespon = pegawai.id 
                                                        GROUP BY request.id HAVING creator = '$_SESSION[nama_user]'";
                                            try {
                                                $query = $mysqli->query($sql);
                                            } catch (mysqli_sql_exception $e) {
                                                echo $e->getMessage();
                                            }
                                            while ($data = mysqli_fetch_assoc($query)) {
                                                $date1        = strtotime($data['created_at']);
                                                $date2        = strtotime($data['update_at']);
                                                $created_date = date('d M Y', $date1);
                                                $update_date  = date('d M Y', $date2);
                                            ?>
                                                <tr>
                                                    <td class='center'><?php echo $no ?></td>
                                                    <td class='center' width='12%'><?php echo $data['id'] ?></td>
                                                    <td class='center '><?php echo $created_date ?></td>
                                                    <td class="center"> <?php echo $data['creator'] ?> </td>
                                                    <td class="center"><span class="badge bg-primary"><?php echo $data['bidang_creator'] ?></span></td>
                                                    <td class="center"><?php echo $data['cordinator']; ?></td>
                                                    <td class="center"><?php echo $data['sub_pesan']; ?></td>
                                                    <td class="center"><?php echo $data['level_prioritas']; ?></td>
                                                    <td class="center"><?php echo $update_date; ?></td>
                                                    <td class='center'><?php echo $data['status'] ?></td>
                                                    <td class="center">
                                                        <div>
                                                            <a data-toggle='tooltip' data-placement='top' title='Lihat Detail' style='margin-right:5px' class='btn btn-primary btn-sm' href='?module=ticket_detail&ticket_id=<?php echo $data['id'] ?>'>
                                                                <i style='color:#fff' class='fa fa-file-alt'></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php $no++;} ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</section>