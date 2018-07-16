<?php include __DIR__.'/header.php';?>


    <main role="main">

      <section class="jumbotron text-center">
        <div class="container"> 
          <p class="lead text-muted">
              软件包管理中心，仅限公司内部使用。 
          </p> 
        </div>
      </section>

      <div class="album py-5 bg-light">
        <div class="container">

          <div class="row">
            <?php foreach($out as $k=>$v){?>
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=<?php echo $k;?>" alt="<?php echo $k;?>">
                <div class="card-body">
                  <p class="card-text">
                      <?php 
                      $Parsedown = new Parsedown(); 
                      echo $Parsedown->text($v['tip']);
                      ?>

                  </p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a  href="/wiki/<?php echo $k;?>" class="btn btn-sm btn-outline-secondary">查看</a>
                     </div>
                    
                  </div>
                </div>
              </div>
            </div>
            <?php }?>
            
         
         

             
            
           
          </div>
        </div>
      </div>

    </main>

<?php include __DIR__.'/footer.php';?>