<?php
$Id = $_GET['Id'];
$job = job()->get("Id=$Id");

function getJobFunction($Id){
  $jf = job_function()->get("Id='$Id'");
  echo $jf->option;
}

function getPositionName($Id){
  $job = position_type()->get("Id='$Id'");
  echo $job->option;
}

function formatDate($val){
  $date = date_create($val);
  return date_format($date, "F d, Y");
}
?>

<div class="container container-fluid">
  <div class="col-12 m-t-30 m-b-30">
    <h2 class="text-blue"><?=$job->position;?></h2>
        <p><label class="m-r-5">Required Experience: </label><?=$job->requiredExperience;?></p>
        <p><label class="m-r-5">Company: </label><?=$job->company;?></p>
        <p><label class="m-r-5">Address: </label><?=$job->address;?></p>
        <p><label class="m-r-5">Zip Code: </label><?=$job->zipCode;?></p>
        <div class="row">
          <div class="col-lg-6">
            <p><label class="m-r-5">Job Category: </label><?=getJobFunction($job->jobFunctionId);?></p>
          </div>
          <div class="col-lg-6">
            <p><label class="m-r-5">Employement Type: </label><?=getPositionName($job->positionTypeId);?></p>
          </div>
        </div>

        <p class="text-muted">Created at: </label><?=formatDate($job->createDate);?></p>
    <div class="row m-t-20">
      <div class="col-lg-6">
        <label class="m-r-5">Contact Person: </label><?=$job->contactName;?>
        <br>
        <?=$job->jobTitle;?>
      </div>
      <div class="col-lg-6">
        <i class="fa fa-envelope m-r-5"></i><?=$job->workEmail;?>
        <br>
        <i class="fa fa-phone m-r-5"></i><?=$job->businessPhone;?>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row m-t-20">
      <div class="col-lg-4">
        ABN: <?=$job->abn;?>
      </div>
      <div class="col-lg-4">
        Reference Number: <?=$job->refNum;?>
      </div>
    </div>
    <div class="clearfix"></div>
    <hr>
    <h3>Hiring Needs</h3>
    <?=$job->comment;?>
    <hr>

        <!--  This button only shows if job is approved -->
        <?php if($job->isApproved==0) {?>
          <button class="btn btn-lg btn-blue" type="button" onclick="location.href='process.php?action=jobRequest&result=approve&Id=<?=$job->Id?>'">Approve</button>
          <button class="btn btn-lg btn-warning" type="button" onclick="location.href='process.php?action=jobRequest&result=moreInfo&Id=<?=$job->Id?>'">Request for more info</button>
          <button class="btn btn-lg btn-success" type="button" data-toggle="modal" data-target="#update-information-modal">Update Info</button>
        <?php } ?>
        <?php if($job->isApproved==-1) {?>
          <button class="btn btn-lg btn-warning" type="button">Waiting for the updated info</button>
        <?php } ?>
        <?php if($job->isApproved==1) {?>
          <button class="btn btn-lg btn-blue" onclick="location.href='?view=employeeList&jobId=<?=$job->Id?>&status=1'">
              View <?=employee()->count("jobId=$job->Id and status=1");?> employees
          </button>
          <button class="btn btn-lg btn-warning" onclick="location.href='?view=timesheetList&jobId=<?=$job->Id?>'">
              View <?=timesheet()->count("jobId=$job->Id");?> timesheets
          </button>
          <button class="btn btn-lg btn-success" onclick="location.href='?view=resumeList&jobId=<?=$job->Id?>&isApproved=0'">
              View <?=resume()->count("jobId=$job->Id and isApproved=0");?> applicants
          </button>
        <?php } ?>
          <button class="btn btn-lg btn-danger" type="button" onclick="location.href='process.php?action=deleteJob&Id=<?=$job->Id?>'">Delete</button>
        <br><br><br><br>
  </div>
</div>
<!-- all modals will be here -->
<div class="clearfix"></div>
<!-- dispute modal content -->
<div id="update-information-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

            <div class="modal-body">
                <h2 class="text-uppercase text-center m-b-30">
                    <a href="index.html" class="text-success">
                        <span><img src="assets/images/logo_dark.png" alt="" height="30"></span>
                    </a>
                </h2>

                <form class="form-horizontal" action="process.php?action=updateInformation&Id=<?=$Id;?>" method="post">
                  <div class="form-group">
                      <label></label>
                      <div>
                          <textarea required="" name="comment" class="form-control"><?=$job->comment;?></textarea>
                      </div>
                  </div>

                    <div class="form-group account-btn text-center m-t-10">
                        <div class="col-xs-12">
                            <button class="btn w-lg btn-rounded btn-lg btn-custom waves-effect waves-light" type="submit">Submit</button>
                        </div>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
