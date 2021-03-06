<?php
$Id = $_GET['Id'];
$resume = resume()->get("Id='$Id'");

function getJobFunction($Id){
  $job = job_function()->get("Id='$Id'");
  echo $job->option;
}

function getCity($Id){
  $city = city_option()->get("Id='$Id'");
  echo $city->city;
}
?>

<div class="container container-fluid">
  <div class="col-12 m-t-30 m-b-30">
      <h2 class="text-blue"><?=$resume->firstName;?> <?=$resume->lastName;?></h2>
      <p><label class="m-r-5">Email: </label><?=$resume->email;?></p>
      <p><label class="m-r-5">Job Category: </label><?=getJobFunction($resume->jobFunctionId);?></p>
      <p><label class="m-r-5">Phone Number: </label><?=$resume->phoneNumber;?></p>
      <div class="col-12">
        <div class="col-lg-6">
          <p><label class="m-r-5">Candidate ABN :</label><?=$resume->abn;?></p>
        </div>
        <div class="col-lg-6">
          <p><label class="m-r-5">Tax File Number :</label><?=$resume->taxNumber;?></p>
        </div>
      </div>
      <div class="col-12">
        <div class="col-lg-6">
          <p><label class="m-r-5">Address 1 :</label><?=$resume->address1;?></p>
        </div>
        <div class="col-lg-6">
          <p><label class="m-r-5">Address 2 :</label><?=$resume->address2;?></p>
        </div>
      </div>
      <p><label class="m-r-5">City :</label><?=getCity($resume->city);?></p>
      <p><label class="m-r-5">State :</label><?=$resume->state;?></p>
      <p><label class="m-r-5">Postal Code :</label><?=$resume->zipCode;?></p>
      <p>
        <label class="m-r-5">Status :</label>
        <?php if($resume->isHired==0 && $resume->isApproved==1){ ?>
        <div class=" btn btn-default btn-xs tooltips">
          Waiting for Interview
        </div>
        <?php }elseif($resume->isHired==1 && $resume->isApproved==1){ ?>
        <div class=" btn btn-success btn-xs tooltips">
          Hired
        </div>
        <?php }else{ ?>
        <div class=" btn btn-warning btn-xs tooltips">
          Pending
        </div>
        <?php } ?>
      </p>
      <hr>
      <div class="col-12 text-center">
        <div class="col-lg-6">
          <p><label class="m-r-5">Cover Letter :</label><br><?=$resume->coverLetter;?></p>
        </div>
        <div class="col-lg-6">
            <p><label class="m-r-5"><strong>Resume :</label><br><?=$resume->uploadedResume;?></p>
        </div>
      </div>
      <div class="clearfix"></div>
      <?php if($resume->isApproved==0){?>
      <div class="col-12 m-t-30">
          <button class="btn btn-lg btn-info" data-toggle="modal" data-target="#schedule-modal">
            Set an Interview
          </button>
          <button onclick="location.href='process.php?action=denyCandidateResume&Id=<?=$resume->Id;?>'" class="btn btn-lg btn-default">Request for More Info</button>
          <button onclick="location.href='process.php?action=deleteCandidateResume&Id=<?=$resume->Id;?>'" class="btn btn-lg btn-danger">Delete</button>
      </div>
      <?php } ?>
      <?php if($resume->isApproved==1 && $resume->isHired==0 && $resume->jobId==0){?>
      <div class="col-12 m-t-30">
        <div class="col-lg-12 text-center">
          <button onclick="location.href='?view=openJobs&Id=<?=$resume->Id;?>'" class="btn btn-info" style="width:350px;">
            Assign Job
          </button>
        </div>
      </div>
      <?php } ?>
      <?php if($resume->isApproved==1 && $resume->jobId!=0 && $resume->isHired==0){?>
      <div class="col-12 m-t-30">
        <div class="col-lg-6">
          <button class="btn btn-success pull-right" style="width:350px;" onclick="location.href='process.php?action=hireApplicant&result=approve&Id=<?=$resume->Id;?>&jobId=<?=$resume->jobId;?>'">
            Hire
          </button>
        </div>
        <div class="col-lg-6">
          <button class="btn btn-danger pull-left" style="width:350px;" onclick="location.href='process.php?action=hireApplicant&result=reject&Id=<?=$resume->Id;?>'">
            Reject
          </button>
        </div>
      </div>
      <?php } ?>
      <?php if($resume->isApproved==1 && $resume->jobId!=0 && $resume->isHired==1){?>
      <div class="col-12 m-t-30">
      </div>
      <?php } ?>
  </div>
</div>

<!-- Schedule and interview modal content -->
<div id="schedule-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

            <div class="modal-body">
                <h2 class="text-uppercase text-center m-b-30">
                    <a href="index.html" class="text-success">
                        <span><img src="assets/images/logo_dark.png" alt="" height="30"></span>
                    </a>
                </h2>

                <form class="form-horizontal" action="process.php?action=setCandidateInterview" method="post">

                      <input type="hidden" name="resumeId" value="<?=$resume->Id;?>">
                      <input type="hidden" name="email" value="<?=$resume->email;?>">
                                        <div class="form-group account-btn text-center m-t-10">
                  <div class="input-group">
                      <input type="date" name="date" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclose" required>
                      <span class="input-group-addon bg-primary b-0"><i class="mdi mdi-calendar text-white mdi-24px"></i></span>
                  </div>
                </div>

                <div class="form-group account-btn text-center m-t-10">
                  <div class="input-group">
                        <input id="timepicker" name="time" type="time" class="form-control" required>
                        <span class="input-group-addon"><i class="mdi mdi-clock mdi-24px"></i></span>
                    </div>  </div>

                    <div class="form-group account-btn text-center m-t-10">
                        <div class="col-xs-12">
                            <button class="btn w-lg btn-rounded btn-lg btn-blue waves-effect waves-light" type="submit">Set</button>
                        </div>
                    </div>

                </form>
  </div>
</div>
</div>
</div>
