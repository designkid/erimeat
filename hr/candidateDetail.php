<?php
$Id = $_GET['Id'];
$resume = resume()->get("Id='$Id'");

$certList = certificates()->list("resumeId='$Id'");

function getJobName($Id){
  $job = job()->get("Id='$Id'");
  return $job->position;
}
?>


<div class="row">
    <div class="col-md-12">
        <!-- Personal-Information -->
        <div class="card-box">
            <h4 class="header-title mt-0 m-b-20">Resume Detail</h4>
            <div class="panel-body">
              <div class="text-left">
                  <p class="text-muted font-13"><strong>Candidate Reference # :</strong>
                    <span class="m-l-15"><?=$resume->refNum;?></span>
                  </p>
                  <p class="text-muted font-13"><strong>Candidate ABN :</strong>
                    <span class="m-l-15"><?=$resume->abn;?></span>
                  </p>
                  <p class="text-muted font-13"><strong>First Name :</strong>
                    <span class="m-l-15"><?=$resume->firstName;?></span>
                  </p>
                  <p class="text-muted font-13"><strong>Last Name :</strong>
                    <span class="m-l-15"><?=$resume->lastName;?></span>
                  </p>
                  <p class="text-muted font-13"><strong>Email :</strong>
                    <span class="m-l-15"><?=$resume->email;?></span>
                  </p>
                  <p class="text-muted font-13"><strong>Phone Number :</strong>
                    <span class="m-l-15"><?=$resume->phoneNumber;?></span>
                  </p>
                  <p class="text-muted font-13"><strong>Address :</strong>
                    <span class="m-l-15"><?=$resume->address1;?> <?=$resume->city;?> <?=$resume->state;?> <?=$resume->zipCode;?></span>
                  </p>
                  <p class="text-muted font-13"><strong>Speedtest :</strong>
                    <span class="m-l-15"><?=$resume->speedtest;?></span>
                  </p>
                  <p>
                    <label class="text-muted font-13">Status :</label>
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
                  <br>
                  <p class="text-muted font-13"><strong>Cover Letter :</strong>
                    <span class="m-l-15"><?=$resume->coverLetter;?></span>
                  </p>
                  <br><br>
                  <p class="text-muted font-13"><strong>Click to view specs</strong>
                    <span class="m-l-15"><a href="../media/<?=$resume->uploadedSpecs;?>" target="blank_">Computer Specification</a></span>
                  </p>
                  <p class="text-muted font-13"><strong>Click to view resume :</strong>
                    <span class="m-l-15"><a href="../media/<?=$resume->uploadedResume;?>" target="blank_">Candidate Resume</a></span>
                  </p>
                  <p class="text-muted font-13"><strong>Click to view certificates :</strong></br>
                    <?php foreach($certList as $row){ ?>
                    <span class="m-l-15"><a href="../media/<?=$row->uploadedCerts;?>" target="blank_">Supporting Documents</a></span><br>
                    <?php }?>
                  </p>
              </div>
            </div>
        </div>
        <!-- Personal-Information -->
        <div class="card-box">
        <?php if($resume->isApproved==0){?>
        <button type="button" class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target="#schedule-modal">Schedule an Interview</button>
        <button class="btn btn-default stepy-finish" onclick="location.href='process.php?action=denyResume&Id=<?=$resume->Id;?>'">Request for More Info</button>
        <button onclick="location.href='process.php?action=deleteCandidateResume&Id=<?=$resume->Id;?>'" class="btn btn-danger">Delete</button>
        <?php } ?>
        <?php if($resume->isApproved==1 && $resume->isHired==0 && $resume->jobId==0){?>
        <button onclick="location.href='?view=openJobs&Id=<?=$resume->Id;?>'" class="btn btn-info" style="width:350px;">
          Assign Job
        </button>
        <?php } ?>
        <?php if($resume->isApproved==1 && $resume->jobId!=0){?>
        <button class="btn btn-success" style="width:350px;" onclick="location.href='process.php?action=hireApplicant&result=approve&Id=<?=$resume->Id;?>&jobId=<?=$resume->jobId;?>'">
          Hire
        </button>
        <button class="btn btn-danger" style="width:350px;" onclick="location.href='process.php?action=hireApplicant&result=reject&Id=<?=$resume->Id;?>'">
          Reject
        </button>
        <?php } ?>
      </div>
  </div>
</div>

  <!-- Signup modal content -->
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

                  <form class="form-horizontal" action="process.php?action=setInterViewDate" method="post">

                        <input type="hidden" name="resumeId" value="<?=$resume->Id;?>">
                        <input type="hidden" name="email" value="<?=$resume->email;?>">
                                          <div class="form-group account-btn text-center m-t-10">
                    <div class="input-group">
                        <input type="date" name="date" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclose" required>
                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                    </div>
                  </div>

                  <div class="form-group account-btn text-center m-t-10">
                    <div class="input-group">
                          <input id="timepicker" name="time" type="time" class="form-control" required>
                          <span class="input-group-addon"><i class="mdi mdi-clock"></i></span>
                      </div>  </div>

                      <div class="form-group account-btn text-center m-t-10">
                          <div class="col-xs-12">
                              <button class="btn w-lg btn-rounded btn-lg btn-custom waves-effect waves-light" type="submit">Set</button>
                          </div>
                      </div>

                  </form>

              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
