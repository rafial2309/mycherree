<!DOCTYPE html>

<html lang="en" class="light">
    <!-- BEGIN: Head -->
    <head>
        <?php include 'layout/head.php' ?>
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
    <body class="login">
        <div class="container sm:px-10">
            <div class="block xl:grid grid-cols-2 gap-4">
                <!-- BEGIN: Login Info -->
                <div class="hidden xl:flex flex-col min-h-screen">
                    <a href="" class="-intro-x flex items-center pt-5">
                        <img alt="My Cherree Laundry" class="w-6" src="dist/images/logo.svg">
                        <span class="text-white text-lg ml-3"> My Cherree Laundry </span> 
                    </a>
                    <div class="my-auto">
                        <img alt="My Cherree Laundry" style="border-radius:8%" class="-intro-x w-1/2 -mt-16" src="dist/logowhite.png">
                        <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                            My Cherree Laundry
                            <br>
                            sign in to your account.
                        </div>
                        <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">Laundry & Dry Cleaning System V1.1</div>
                    </div>
                </div>
                <!-- END: Login Info -->
                <!-- BEGIN: Login Form -->
                <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                    <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                        <form method="POST" action="function/auth_process">
                        <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                            Sign In
                        </h2>
                        
                        <div class="intro-x mt-8">
                            <?php if (isset($_GET['error'])) { ?>
                            <div class="alert alert-outline-danger alert-dismissible show flex items-center mb-2" role="alert"> <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i> <?php echo $_GET['msg'] ?> <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button> </div>
                            <?php } ?>
                            <input type="text" name="id" class="intro-x login__input form-control py-3 px-4 block" placeholder="Staff ID">
                            <input type="password" name="pin" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="PIN">
                            <select class="form-select form-select-lg sm:mt-2 sm:mr-2" aria-label=".form-select-lg example" name="cabang">
                                 <option value="MCL1">MCL1</option>
                                 <option value="MCL2">MCL2</option>
                             </select>
                        </div>
                        
                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <button class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Login</button>
                            
                        </div>
                        <div class="intro-x mt-10 xl:mt-24 text-slate-600 dark:text-slate-500 text-center xl:text-left"> Copyright 2022 My Cherree Laundry</div>
                        </form>
                    </div>
                </div>
                <!-- END: Login Form -->
            </div>
        </div>
        <!-- BEGIN: Dark Mode Switcher-->
        <div data-url="login-dark-login.html" class="dark-mode-switcher cursor-pointer shadow-md fixed bottom-0 right-0 box border rounded-full w-40 h-12 flex items-center justify-center z-50 mb-10 mr-10">
            <div class="mr-4 text-slate-600 dark:text-slate-200">Dark Mode</div>
            <div class="dark-mode-switcher__toggle border"></div>
        </div>
        <!-- END: Dark Mode Switcher-->
        
        <!-- BEGIN: JS Assets-->
        <script src="dist/js/app.js"></script>
        <!-- END: JS Assets-->
    </body>
</html>