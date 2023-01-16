<?php

namespace Views\Components;

use Infinitesimal\Infinitesimal;
use Infinitesimal\Url;

class HtmlHead
{
    public function __construct()
    {
        ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=width, initial-scale=1">

		<script src="<?= Url::Resource('js/jquery-3.5.1.min.js') ?>"></script>
		<script src="<?= Url::Resource('js/jquery-ui.min.js') ?>"></script>
		<script src="<?= Url::Resource('js/jquery.ui.touch-punch.min.js') ?>"></script>
		<script src="<?= Url::Resource('js/bootstrap.min.js') ?>"></script>
		<script src="<?= Url::Resource('DataTables/datatables.min.js') ?>"></script>
		<script src="<?= Url::Resource('js/scripts.js') ?>"></script>
		<script src="<?= Url::Resource('js/bootstrap-notify.js') ?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

		<link rel="stylesheet" href="<?= Url::Resource('css/style.css') ?>">
		<link rel="stylesheet" href="<?= Url::Resource('css/jquery-ui.css') ?>">
		<link href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" rel="stylesheet">
		<link rel="stylesheet" href="<?= Url::Resource('css/font-awesome-all.css') ?>">
		<link rel="stylesheet" href="<?= Url::Resource('css/bootstrap.min.css') ?>">
		<link rel="stylesheet" href="<?= Url::Resource('css/mdb.min.css') ?>">
		<link rel="stylesheet" href="<?= Url::Resource('DataTables/datatables.min.css') ?>">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <style>
            .botones-compartir {
                align-items: center;
                display: flex;
                flex-direction: column;
            }
        </style>

		<!--Datepicker-->
		<!--<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>/-->
		<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
		
		<!-- Google Fonts -->
		<!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700&display=swap">-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mulish:300,400,500,700&display=swap">
		<!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">-->
		
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-GE41DPQ4Q1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'G-GE41DPQ4Q1');
		</script>
		
        <?php
    }

} 