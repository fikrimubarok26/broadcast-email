<div id="layoutSidenav_content">
     <main>
         <div class="container-fluid">
             <h3 class="mt-4">Pengirim</h3>
             <ol class="breadcrumb mb-4">
                 <li class="breadcrumb-item"><a href="<?= base_url() ?>">Dashboard</a></li>
                 <li class="breadcrumb-item active"> Data Pengirim</li>
             </ol>
             <?php echo $crud->output; ?>
             <div style="height: 100vh;"></div>

         </div>
     </main>
 </div>

 <script>
     document.getElementsByClassName('groceryCrudTable')[0].classList.add('table-sm')
 </script>