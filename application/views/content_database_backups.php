<main role="main" class="container">
    <div class="row agricon-content-title">
        <h3><?php echo $title; ?></h3>
        <div id="agricon_alert_container">
            <?php
            if (isset($alert->show)) {
                ?>
                <div class="alert agricon-alert alert-dismissible fade show<?php echo $alert->class ?>" role="alert">
                    <?php echo $alert->message ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <div class="row">
        <div class="container" id="dbBackup_content">
            <div class="row">
                <div class="col-12" style="height: 50px">
                    <?php
                    if(isset($dbmessage)){
                        if ($dbmessage != null) {
                            if ($dbmessage == "success") {
                                echo '<span style="color:green"> Backup is opgeslagen op de server.</span>';
                            }
                            else {
                                echo '<span style="color:red"> Het maken van de backup is mislukt. Contacteer de administrator a.u.b.</span>';
                            }
                        }
                    }
                    if(isset($uploadmessage)){
                        if ($uploadmessage != null) {
                            if ($uploadmessage == "success") {
                                echo '<span style="color:green"> Backup geupload naar de server!</span>';
                            }
                            else {
                                echo '<span style="color:red">' . $uploadmessage . '</span>';
                            }
                        }
                    }
                    if(isset($dbimportmessage)){
                        if ($dbimportmessage != null) {
                            if ($dbimportmessage == "success") {
                                echo '<span style="color:green"> Backup is uitgevoerd, database is hersteld!</span>';
                            }
                            else {
                                echo '<span style="color:red"> Er liep iets mis. De backup is niet uitgevoerd, database is niet hersteld!</span>';
                            }
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4" style="margin-top: 10px">
                    <h4>Backup maken</h4>
                    <div style="height: 40px">
                        <input type="text" id="dbBackupComment_input" name="dbBackupComment"
                               placeholder="Omschrijving">
                    </div>
                    <div>
                        <?php echo anchor('database_backup/export_db_backup/server', 'Naar server', 'id="dbExportToServer" class="btn btn-outline-success dbBackupButton triggerDbExport" role="button"'); ?>
                    </div>
                    <div style="padding-top:15px">
                        <?php echo anchor('database_backup/export_db_backup/pc', 'Naar pc', 'id="dbExportToPc" class="btn btn-outline-success dbBackupButton triggerDbExport" role="button" download'); ?>
                    </div>
                </div>

                <div class="col-lg-8" style="margin-top: 10px">
                    <h4>Backup herstellen</h4>
                    <div style="height: 40px">
                        <input hidden>
                    </div>
                    <div>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_execute_backup_from_server',
                            'name' => 'form_execute_backup_from_server',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_execute_backup_from_server',
                            'name' => 'submit_execute_backup_from_server',
                            'type' => 'submit',
                            'value' => 'Van server',
                            'class' => 'btn btn-outline-success dbBackupButton');

                        echo form_open('database_backup/import_db_backup/server', $dataOpen);

                        echo form_dropdown('gekozen_sqlnaam', $sqlbackups_dropdownOptions, '', 'id="gekozen_sqlnaam" class="form-control dbDropdown" required="required" ');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>

                    <div style="padding-top:15px">
                        <?php
                        echo form_open_multipart('database_backup/import_db_backup/pc');
                        ?>
                        <!--  https://www.abeautifulsite.net/whipping-file-inputs-into-shape-with-bootstrap-3-->
                        <div class="input-group uploadFileContainer">
                            <label class="input-group-btn">
                                    <span class="btn btn-outline-default browseButton">
                                        Bestand kiezen
                                    </span><input type="file" name="userfile" style="display: none;">
                            </label>
                        </div>
                        <input class="btn btn-outline-success dbBackupButton" type="submit" value="Van pc">
                    </div>
                </div>
            </div>


        </div>
    </div>
</main>
<script>
    var backupMessage = "global";
    $(document).on('change', ':file', function () {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    $(document).ready(function () {
        $('#agricon_alert_container').hide();

        $('#dbBackupComment_input').keyup(function () {
            if ($(this).val() != "" && $(this).val() != null) {
                backupMessage = $(this).val();
                $("#dbExportToServer").attr("href", site_url + "/database_backup/export_db_backup/server/" + backupMessage);
                $("#dbExportToPc").attr("href", site_url + "/database_backup/export_db_backup/pc/" + backupMessage);
            } else {
                $("#dbExportToServer").attr("href", site_url + "/database_backup/export_db_backup/server");
                $("#dbExportToPc").attr("href", site_url + "/database_backup/export_db_backup/pc");
            }
        });

        $(':file').on('fileselect', function (event, numFiles, label) {
            $("span.browseButton").text(label);
        });
    });
</script>
