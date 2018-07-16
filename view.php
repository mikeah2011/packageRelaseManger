<?php include __DIR__.'/header.php';?>


    <main role="main">

      <section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading"><?php echo $type;?></h1>
          <p class="lead text-muted">
             版本号：<?php echo $version;?>
          </p> 

          <a style="margin-left: 10px;" class="btn btn-primary my-2" href="/download/<?php echo $type;?>?version=<?php echo $version; ?>">下载</a>

        </div>
      </section>

      <div class="album py-5 bg-light">
        <div class="container">
              
          <?php $mk = $out[$type]['lists'][$version]['readme'];?>
          <?php 
                      $Parsedown = new Parsedown(); 
                      echo $Parsedown->text($mk);
          ?>
        </div>
      </div>

    </main>

<?php include __DIR__.'/footer.php';?>