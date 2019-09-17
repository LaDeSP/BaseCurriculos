<template>
<!-- Modal -->
<div class="modal fade" id="tunder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel" >Quem é você?</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <!-- body -->
        <div class="modal-header">
            <div class="form-group">
               <div class="row">
                    <div class="col-lg-6 text-center">
                      <i class="far fa-user fa-5x login-icon"></i>
                      <a class="btn btn-primary btn-md text-uppercase inferno" href="#fisica"  data-toggle="modal" data-target="#fisica">Pessoa Física</a>
                    </div>
                    <div class="col-lg-6 text-center" >
                        <i class="fas fa-building fa-5x login-icon"></i>
                        <a class="btn btn-primary btn-md text-uppercase inferno " href="#juridica"  data-toggle="modal" data-target="#juridica">Pessoa Jurídica</a>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--  end-Modal1 -->

</template>
