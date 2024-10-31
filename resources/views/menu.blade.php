<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/4ca8bfb5f5.js" crossorigin="anonymous"></script>
    <style>
        body {
            min-height: 100vh;
            background: #fafafa;
        }

        .social-link {
            width: 30px;
            height: 30px;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            border-radius: 50%;
            transition: all 0.3s;
            font-size: 0.9rem;
            text-decoration: none; /* Remove text decoration */
        }

        .social-link:hover, .social-link:focus {
            background: #ddd;
            color: #555;
        }

        .progress {
            height: 10px;
        }

        /* Smooth animation */
        .card.hoverable {
            transition: all 0.3s ease;
        }

        /* Smooth hover effect */
        .card.hoverable:hover {
            transform: translateY(-5px); /* Adjust the translateY for smoothness */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1); /* Adjust box-shadow for smoothness */
        }

        /* Remove underline from all links */
        a {
            text-decoration: none;
        }
    </style>
  </head>
  <body>
    <div class="container py-5">
        <!-- Start -->
        <header class="text-center mb-5">
            <h1 class="display-4 font-weight-bold">Request Menu</h1>
            <p class="font-italic text-muted mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
        </header>

        {{-- <!-- First Row [Statistics]-->
        <h2 class="font-weight-bold mb-2">Latest Statistics</h2> --}}

        <div class="row pb-5">
            <div class="col-lg-6 col-md-6 mb-4 mb-lg-0">
                <!-- Card-->
                <a href="/dashboard" class="card rounded shadow-sm border-2 hoverable">
                    <div class="card-body p-5"><i class="fa-regular fa-clipboard fa-3x mb-3 text-primary"></i>
                        <h3>Purchase Requisition (PR)</h3>
                        <p class="small text-muted font-italic">Request Purchase Requisition, Add Part Stock.</p>
                        <div class="progress rounded-pill">
                            <div role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;" class="progress-bar rounded-pill"></div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-6 col-md-6 mb-4 mb-lg-0">
                <!-- Card -->
                <a href="/gatepass" class="card rounded shadow-sm border-2 hoverable">
                    <div class="card-body p-5"><i class="fa-solid fa-arrow-right-arrow-left fa-3x mb-3 text-success"></i>
                        <h3>Gate Pass</h3>
                        <p class="small text-muted font-italic">Security gate pass approval, Upload photo of the unit, Remarks condition of the unit.</p>
                        <div class="progress rounded-pill">
                            <div role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;" class="progress-bar bg-success rounded-pill"></div>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
  </body>
</html>
