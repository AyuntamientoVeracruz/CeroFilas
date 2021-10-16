<?php $__env->startSection('page-style-files'); ?>
<style type="text/css">
.table th, .table td{    padding: 0.45rem 0.35rem; font-size: 12.5px}
  tr.hide{ display:none; background:#fff!important}
  tr.open{ display:table-row}
  table th {
      border-top: 0px none!important;
      padding-top: 0px!important;
  }
  .datepicker{ padding: 8px!important }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <!-- Main content -->
  <main class="main">

    <!-- Breadcrumb -->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      <!--<li class="breadcrumb-item"><a href="#">Admin</a></li>-->
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <div class="container-fluid">

      <div class="animated fadeIn cards">
        
          <div class="col-lg-12">              
            
          </div>

          



      </div>

    </div>

  </main>

  

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-js-script'); ?>
  <script>
    $(document).ready(function(){
      $(".loading-main").fadeOut();      
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.headerauth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>