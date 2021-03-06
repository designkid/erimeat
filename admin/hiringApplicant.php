<?php
$Id = $_GET['Id'];
$resume = resume()->get("Id='$Id'");
$jobId = $_GET['jobId'];

function getJobName($Id){
  $job = job()->get("Id='$Id'");
  return $job->position;
}

function getJobCategory($Id){
  $jobFunc = job_function()->get("Id='$Id'");
  return $jobFunc->option;
}
?>


<div class="row">
    <div class="col-md-12">
        <!-- Personal-Information -->
        <div class="card-box">
            <h4 class="header-title mt-0 m-b-20">Resume Detail</h4>
            <div class="panel-body">
                <div class="text-left">
                    <p class="text-muted font-13"><strong>Applying for :</strong>
                      <span class="m-l-15"><?=getJobName($resume->jobId);?></span>
                    </p>
                    <p class="text-muted font-13"><strong>Candidate Name :</strong>
                      <span class="m-l-15"><?=$resume->firstName;?> <?=$resume->lastName;?></span>
                    </p>
                    <p class="text-muted font-13"><strong>Candidate ABN :</strong>
                      <span class="m-l-15"><?=$resume->abn;?></span>
                    </p>
                    <p class="text-muted font-13"><strong>Candidate Email :</strong>
                      <span class="m-l-15"><?=$resume->email;?></span>
                    </p>
                    <p class="text-muted font-13"><strong>Job Category :</strong>
                      <span class="m-l-15"><?=getJobCategory($resume->jobFunctionId);?></span>
                    </p>
                    <p class="text-muted font-13"><strong>Phone Number :</strong>
                      <span class="m-l-15"><?=$resume->phoneNumber;?></span>
                    </p>
                    <p class="text-muted font-13"><strong><a href="../media/<?=$resume->uploadedResume;?>" target="blank_">Click to view resume</a></strong></p>
                </div>
            </div>
        </div>
        <!-- Personal-Information -->
        <div class="card-box">
          <button class="btn btn-default" onclick="location.href='process.php?action=hireApplicant&result=approve&Id=<?=$resume->Id;?>&jobId=<?=$jobId;?>'">Hire</button>
          <button class="btn btn-default" onclick="location.href='process.php?action=hireApplicant&result=deny&Id=<?=$resume->Id;?>'">Deny</button>
        </div>
    </div>
  </div>
