<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detail Ticket</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="main.php?module=home">Home</a></li>
                    <li class="breadcrumb-item active">Detail Ticket</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <div class="modal fade" id="respon_modal">
        <form id="detail_form" method="post" action="api.php/add_ticket_detail">
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
                        <div class="form-group">
                            <label for="editor">Deskripsi</label>
                            <div id="toolbar-container"></div>
                            <div id="editor1"></div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="ticket_id" value="<?php echo $_GET['ticket_id'] ?>">
                            <input type="hidden" name="responder_id" value="<?php echo $_SESSION['id_user'] ?>">
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
        <!-- Timelime example  -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Timeline</h3>
                    </div>
                    <div class="card-body tab-custom">
                        <div class="timeline">
                            <!-- timeline time label -->
                            <?php
                            $sql = "SELECT request.*,pegawai.nama,pegawai.bidang  FROM tb_request request
                            LEFT JOIN tb_perespon perespon ON (perespon.id_req = request.id AND perespon.tipe_perespon='creator')
                            LEFT JOIN tb_pegawai pegawai ON pegawai.id = perespon.id_perespon 
                            WHERE request.id = '$_GET[ticket_id]';";
                            $result = $mysqli->query($sql);
                            $data = $result->fetch_assoc();
                            $date1        = strtotime($data['created_at']);
                            $created_date = date('j F, Y', $date1);
                            $created_time = date('H:i', $date1);
                            ?>
                            <div class="time-label">
                                <span class="bg-info"><?php echo $created_date ?></span>
                            </div>
                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                            <div>
                                <i class="fas fa-envelope bg-blue"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> <?php echo $created_time ?></span>
                                    <h3 class="timeline-header"><a><?php echo $data['bidang'] ?></a> <?php echo $data['nama'] ?> create a ticket</h3>
                                    <div class="timeline-body center">
                                        <div class="ck-restricted-editing_mode_standard ck ck-content ck-rounded-corners ck-read-only ck-column-resize_disabled ck-blurred" lang="en" dir="ltr" role="textbox">
                                            <?php echo $data['deskripsi'] ?>
                                        </div>
                                    </div>
                                    <div class="timeline-footer">
                                    </div>
                                </div>
                            </div>
                            <?php
                            $sql = "SELECT pegawai.nama ,pegawai.bidang ,detail_respon.deskripsi,detail_respon.tipe_detail,detail_respon.respon_at 
                                        FROM tb_detail_respon detail_respon
                                        LEFT JOIN tb_perespon perespon ON perespon.id = detail_respon.id_respon 
                                        LEFT JOIN tb_pegawai pegawai ON pegawai.id = perespon.id_perespon 
                                        WHERE perespon.id_req = '$_GET[ticket_id]'";
                            $result = $mysqli->query($sql);
                            while ($data = $result->fetch_assoc()) {
                                $date1        = strtotime($data['respon_at']);
                                $created_date1 = date('j F, Y', $date1);
                                $created_time = date('H:i', $date1);
                                if ($created_date != $created_date1) {
                                    $created_date = $created_date1;
                            ?>
                                    <div class="time-label">
                                        <span class="bg-info"><?php echo $created_date ?></span>
                                    </div>
                                <?php
                                }
                                if ($data['tipe_detail'] == 'accept') {
                                ?>
                                    <div>
                                        <i class="fa fa-user-check bg-success"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i> <?php echo $created_time ?></span>

                                            <h3 class="timeline-header"><a><?php echo $data['bidang'] ?></a> <?php echo $data['nama'] ?> Accept Ticket</h3>

                                        </div>
                                    </div>
                                <?php
                                } elseif ($data['tipe_detail'] == 'response') {
                                ?>
                                    <div>
                                        <i class="fas fa-envelope bg-blue"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i> <?php echo $created_time ?></span>
                                            <h3 class="timeline-header"><a><?php echo $data['bidang'] ?></a> <?php echo $data['nama'] ?> Send a response</h3>
                                            <div class="timeline-body center">
                                                <div class="ck-restricted-editing_mode_standard ck ck-content ck-rounded-corners ck-read-only ck-column-resize_disabled ck-blurred" lang="en" dir="ltr" role="textbox">
                                                    <?php echo $data['deskripsi'] ?>
                                                </div>
                                            </div>
                                            <div class="timeline-footer">
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } elseif ($data['tipe_detail'] == 'refuse') {
                                ?>
                                    <div>
                                        <i class="fa fa-times bg-danger"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i> <?php echo $created_time ?></span>

                                            <h3 class="timeline-header"><a><?php echo $data['bidang'] ?></a> <?php echo $data['nama'] ?> Refused Ticket</h3>

                                        </div>
                                    </div>
                                <?php
                                } elseif ($data['tipe_detail'] == 'done') {
                                ?>
                                    <div>
                                        <i class="fa fa-check bg-success"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i> <?php echo $created_time ?></span>

                                            <h3 class="timeline-header"><a><?php echo $data['bidang'] ?></a> <?php echo $data['nama'] ?> Mark Ticket as Done</h3>

                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                            <!-- END timeline item -->
                            <!-- timeline item -->
                            <div>
                                <i class="fas fa-clock bg-gray"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#respon_modal">beri respon</button>
                    </div>
                </div>
                <!-- The time line -->
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ticket Information</h3>
                    </div>
                    <div class="card-body tab-custom">
                        <h5>Ticket Information</h5>
                        <div class="form-group">
                            <label for="ticket_id">Ticket ID</label>
                            <input type="text" value="<?php echo $_GET['ticket_id'] ?>" class="form-control" id="ticket_id" name="ticket_id" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="ticket_sub">Subject</label>
                            <input type="text" class="form-control" id="ticket_sub" name="ticket_sub" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="responders">Responder</label>
                            <select class="form-control" id="responder_select" name="responders[]" multiple="multiple" required disabled>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ticket_priority">Priority Level</label>
                            <input type="text" class="form-control" id="ticket_priority" name="ticket_priority" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="ticket_status">Status</label>
                            <input type="text" class="form-control" id="ticket_status" name="ticket_status" required readonly>
                        </div>
                    </div>
                    <div class="card-footer">
                        <?php if ($_SESSION['bidang'] == 'GA') { ?>
                            <form id="mark_form" method="post" action="api.php/add_ticket_detail">
                                <input type="hidden" name="ticket_id" value="<?php echo $_GET['ticket_id'] ?>">
                                <input type="hidden" name="responder_id" value="<?php echo $_SESSION['id_user'] ?>">
                                <button type="submit" name="detail_type" value="accept" class="btn btn-primary">Accept</button>
                                <button type="submit" name="detail_type" value="refuse" class="btn btn-danger">Refuse</button>
                                <button type="submit" name="detail_type" value="done" class="btn btn-success"> Mark as done</button>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
    </div>
    <!-- /.timeline -->

</section>