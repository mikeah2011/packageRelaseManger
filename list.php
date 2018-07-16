<?php include __DIR__.'/header.php';?>


    <main role="main">
 

      <div class="container  py-5">
                
                <small>
                  <?php 
                      $Parsedown = new Parsedown(); 
                      echo $Parsedown->text($out[$type]['tip']);
                 ?><?php echo $type;?>
                </small>
                <ul class="list-group" >
                  <?php foreach($out[$type]['lists'] as $key=>$vo){?>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                      <?php echo $key; ?>（<?php echo $vo['tip']; ?>）
                      <span class="pull-right">
                        <a href="/view/<?php echo $type;?>?version=<?php echo $key; ?>">查看更新日志</a>
                        <a style="margin-left: 10px;" href="/download/<?php echo $type;?>?version=<?php echo $key; ?>">下载</a>
                      </span>
                    
                  </li>
                  <?php }?>
                </ul>
           
      </div>

    </main>

<?php include __DIR__.'/footer.php';?>