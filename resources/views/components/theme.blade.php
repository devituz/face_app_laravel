<form class="offcanvas offcanvas-end" id="offcanvasDemo" tabindex="-1">
    <div class="offcanvas-body">
        <a class="btn-close" href="index.html#" data-bs-dismiss="offcanvas" aria-label="Close"></a>
        <div class="text-center">
            <img src="assets/img/illustrations/designer-life.svg" alt="..." class="img-fluid mb-3">
        </div>

        <!-- Heading -->
        <h2 class="text-center mb-2">
            Make Dashkit Your Own
        </h2>

        <!-- Text -->
        <p class="text-center mb-4">
            Set preferences that will be cookied for your live preview demonstration.
        </p>

        <!-- Divider -->
        <hr class="mb-4">

        <!-- Heading -->
        <h4 class="mb-1">
            Color Scheme
        </h4>

        <!-- Text -->
        <p class="small text-body-secondary mb-3">
            Overall light or dark presentation.
        </p>

        <!-- Button group -->
        <div class="btn-group-toggle row gx-2 mb-4">
            <div class="col">
                <input class="btn-check" name="colorScheme" id="colorSchemeLight" type="radio" value="light">
                <label class="btn w-100 btn-white" for="colorSchemeLight">
                    <i class="fe fe-sun me-2"></i> Light Mode
                </label>
            </div>
            <div class="col">
                <input class="btn-check" name="colorScheme" id="colorSchemeDark" type="radio" value="dark">
                <label class="btn w-100 btn-white" for="colorSchemeDark">
                    <i class="fe fe-moon me-2"></i> Dark Mode
                </label>
            </div>
        </div>



        <!-- Button group -->
        <div class="btn-group-toggle row gx-2 mb-4">
            <div class="col">
                <input class="btn-check" name="navPosition" id="navPositionSidenav" type="radio" value="sidenav">

            </div>
            <div class="col">
                <input class="btn-check" name="navPosition" id="navPositionTopnav" type="radio" value="topnav">

            </div>
            <div class="col">
                <input class="btn-check" name="navPosition" id="navPositionCombo" type="radio" value="combo">

            </div>
        </div>

        <!-- Collapse -->
        <div id="sidebarSizeContainer">

            <!-- Button group -->
            <div class="btn-group-toggle row gx-2 mb-4">
                <div class="col">
                    <input class="btn-check" name="sidebarSize" id="sidebarSizeBase" type="radio" value="base">
                </div>
                <div class="col">
                    <input class="btn-check" name="sidebarSize" id="sidebarSizeSmall" type="radio" value="small">
                </div>
            </div>

        </div>


        <!-- Button group -->
        <div class="btn-group-toggle row gx-2">
            <div class="col">
                <input class="btn-check" name="navColor" id="navColorDefault" type="radio" value="default">

            </div>
            <div class="col">
                <input class="btn-check" name="navColor" id="navColorInverted" type="radio" value="inverted">
            </div>
            <div class="col">
                <input class="btn-check" name="navColor" id="navColorVibrant" type="radio" value="vibrant">
            </div>
        </div>

    </div>
    <div class="offcanvas-header">

        <!-- Button -->
        <button type="submit" class="btn w-100 btn-primary mt-auto">
            Preview
        </button>

    </div>
</form>
