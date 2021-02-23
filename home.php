<?php
include 'include/header.php';
?>
<body>
<style>
  .rewardimg {
  object-fit: contain;
  display: block; 
  overflow: auto; 
  margin-left: auto;
  margin-right: auto;
}
</style>
  <div class="d-flex" id="wrapper">
  	<?php include 'include/navbar.php';?>
    <div class="container-fluid">
     <h4 class="my-5"><i class='fas fa-gift'></i> Reward</h4>

                      

                        <div class="container-fluid">
                          <div class="card-body">
                               <div class="row mb-3">
                                <div class="col text-right">
                                  <form>
                                    <input type="checkbox" id="affordpoint" > Afford Point
                                    <select type="text" class="form-control-sm" id="category">
                                      <option type="text" value="all">All</option>
                                      <option type="text" value="Gift">Gift</option>
                                      <option type="text" value="Cash">Cash</option>
                                      <option type="text" value="Voucher">Voucher</option>
                                      <option type="text" value="Item">Item</option>
                                      <option type="text" value="Other">Other</option>
                                    </select>
                                  </form>
                                </div>
                            </div>

                      <div class="row px-sm-2 px-0" id="catdata">
                        <div class="col-sm-4 col-lg-3 col-md-3">
                          
                          <div class="card" style="border:1px solid #ccc; border-radius:5px; padding:16px; margin-bottom:16px; ">
							<div class="d-flex card-img-top"><img src="img/jaehyun.jpg" width="180" height="200"  alt="Reward Picture" class="rewardimg"></div>


                              <div class="card-body">
                                <h5 class="card-title">
                                  <span class='badge badge-success'>
                                    hey
                                  </span>
                                  <strong>hey</strong>
                                </h5>
                                <p class="card-text">
                                <span class='badge badge-pill badge-warning'> P </span>
                                  hey<br>
                                  hey<br>
                                  Valid til: 9
                                </p>

                            <button type="button" class="btn btn-primary pull-right viewreward" data-toggle="modal" data-target="#viewreward" data-backdrop="static" id="">Claim</button>
                              </div>
                          </div>
                        </div>
                      
                    </div>
                  </div>

                  </div>
                </div> 
              </div>
            </body> 

    