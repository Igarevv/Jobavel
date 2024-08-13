<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobavel Resume</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style nonce="{{ csp_nonce() }}">
        .a4-wrapper {
            position: relative;
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 30px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            background: white;
        }

        .top-text {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px;
            border-bottom: 1px solid #5c585838;
            width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .cv-section {
            margin-bottom: 20px;
        }

        .font-20 {
            font-size: 20px;
        }

        .red {
            color: #f9322c;
        }

        .font-18 {
            font-size: 18px;
        }
        
        .bg-color-dark {
            background-color: rgba(243, 21, 21, 0.7);
        }

        .text-white {
            color: white;
        }
    </style>
</head>
<body>
<div class="a4-wrapper">
    <div class="top-text">
        <span class="font-20 fw-bold">Job<span class="red">avel</span> <span
                    class="font-18 fw-normal">Resume</span></span>
    </div>

    <div class="header">
        <h1>{{ $employee->lastName.' '.$employee->firstName }}</h1>
    </div>
    <div class="cv-section">
        <h4 class="fw-bold">Position</h4>
        <p>{{ $employee->currentPosition }}</p>
    </div>
    <div class="cv-section">
        <h4 class="fw-bold">Preferred salary</h4>
        <p>{{ $employee->salary ? '$'.$employee->salary : 'Not specified' }}</p>
    </div>
    <div class="cv-section">
        <h4 class="fw-bold">About me</h4>
        <p>{{ $employee->aboutEmployee }}</p>
    </div>
    @if($skillsInRaw)
        <div class="cv-section">
            <h4 class="fw-bold">Skills</h4>
            <p>{{ $skillsInRaw }}</p>
        </div>
    @endif
    @if($employee->experiences)
        @foreach($employee->experiences as $index => $experience)
            <div class="experience-item mb-3">
                <div class="d-flex flex-column flex-md-row px-3 py-2 justify-content-between bg-color-dark">
                    <div class="editable-container d-flex flex-column flex-md-row align-items-start align-items-md-center gap-1">
                        <div>
                            <h6 class="editable-input d-inline input-hover-white text-node text-white fw-bold">{{ $experience->position }}</h6>
                        </div>
                        <div>
                            <h6 class="d-inline text-white"> at </h6>
                        </div>
                        <div>
                            <h6 class="editable-input d-inline input-hover-white text-white">{{ $experience->company }}</h6>
                        </div>
                    </div>
                    <div class="editable-container d-flex flex-column flex-md-row align-items-start align-items-md-center gap-1 mt-2 mt-md-0">
                        <div>
                            <h6 class="editable-input d-inline input-hover-white fw-bold text-white">{{ $experience->from }}</h6>
                        </div>
                        <div>
                            <h6 class="d-inline fw-bold text-white"> ⎯ </h6>
                        </div>
                        <div>
                            <h6 class="editable-input d-inline input-hover-white fw-bold text-white">{{ $experience->to }}</h6>
                        </div>
                    </div>
                </div>
                <div class="editable-section mt-2">
                    <div class="container">
                        <ul id="description-list-{{ $index }}">
                            @if (isset($experience->description))
                                @foreach ($experience->description as $descIndex => $description)
                                    <li class="mb-2">
                                        <div class="editable-input input-group input-field-{{ $index }} d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                            <span class="text-node input-hover text-14">{{ $description }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p class="text-muted">Experience not specified</p>
    @endif
</div>
</body>
</html>
