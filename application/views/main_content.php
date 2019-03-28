<main role="main" class="container">
    <div class="row agricon-content-title">
<!--        <h3>--><?php //echo $title; ?><!--</h3>-->
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

<!--    <div class="row">-->
<!--        <div class="container">-->
<!--            <section>-->
<!--                <p class="lead">-->
<!--                    Kostprijsberekeningen van eindproducten-->
<!--                </p>-->
<!--                <br/>-->
<!--                <p>-->
<!--                    Gebruikers kunnen inloggen met volgende gegevens:<br/>-->
<!--                    Naam: user <br/>-->
<!--                    Wachtwoord: user <br/>-->
<!--                </p>-->
<!--            </section>-->
<!--        </div>-->
<!--    </div>-->

    <div class="row">
        <div class="container">
            <section>
                <?php echo image('agriconLogo_original.jpg','style="display: block;margin-left: auto;margin-right: auto;margin-top:12%"'); ?>
            </section>
        </div>
    </div>
</main>

<script>
    $(document).ready(function () {
        $('#agricon_alert_container').hide();
    });
</script>