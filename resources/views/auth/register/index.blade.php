

 <!-- Vertical Wizard -->
 <section class="vertical-wizard">
    <div class="bs-stepper vertical vertical-wizard-example">
        <div class="bs-stepper-header">
            <div class="step" data-target="#account-details-vertical">
                <button type="button" class="step-trigger">
                    <span class="bs-stepper-box">1</span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Account Details</span>
                        <span class="bs-stepper-subtitle">Setup Account Details</span>
                    </span>
                </button>
            </div>
            <div class="step" data-target="#personal-info-vertical">
                <button type="button" class="step-trigger">
                    <span class="bs-stepper-box">2</span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Personal Info</span>
                        <span class="bs-stepper-subtitle">Add Personal Info</span>
                    </span>
                </button>
            </div>
            <div class="step" data-target="#address-step-vertical">
                <button type="button" class="step-trigger">
                    <span class="bs-stepper-box">3</span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Address</span>
                        <span class="bs-stepper-subtitle">Add Address</span>
                    </span>
                </button>
            </div>

        </div>
        <div class="bs-stepper-content">
            <div id="account-details-vertical" class="content">
                <div class="content-header">
                    <h5 class="mb-0">Account Details</h5>
                    <small class="text-muted">Enter Your Account Details.</small>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="vertical-username">Username</label>
                        <input type="text" id="vertical-username" class="form-control" placeholder="johndoe" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="vertical-email">Email</label>
                        <input type="email" id="vertical-email" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe" />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group form-password-toggle col-md-6">
                        <label class="form-label" for="vertical-password">Password</label>
                        <input type="password" id="vertical-password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                    </div>
                    <div class="form-group form-password-toggle col-md-6">
                        <label class="form-label" for="vertical-confirm-password">Confirm Password</label>
                        <input type="password" id="vertical-confirm-password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-outline-secondary btn-prev" disabled>
                        <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                    </button>
                    <button class="btn btn-primary btn-next">
                        <span class="align-middle d-sm-inline-block d-none">Next</span>
                        <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                    </button>
                </div>
            </div>
            <div id="personal-info-vertical" class="content">
                <div class="content-header">
                    <h5 class="mb-0">Personal Info</h5>
                    <small>Enter Your Personal Info.</small>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="vertical-first-name">First Name</label>
                        <input type="text" id="vertical-first-name" class="form-control" placeholder="John" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="vertical-last-name">Last Name</label>
                        <input type="text" id="vertical-last-name" class="form-control" placeholder="Doe" />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="vertical-country">Country</label>
                        <select class="select2 w-100" id="vertical-country">
                            <option label=" "></option>
                            <option>UK</option>
                            <option>USA</option>
                            <option>Spain</option>
                            <option>France</option>
                            <option>Italy</option>
                            <option>Australia</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="vertical-language">Language</label>
                        <select class="select2 w-100" id="vertical-language" multiple>
                            <option>English</option>
                            <option>French</option>
                            <option>Spanish</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary btn-prev">
                        <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                    </button>
                    <button class="btn btn-primary btn-next">
                        <span class="align-middle d-sm-inline-block d-none">Next</span>
                        <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                    </button>
                </div>
            </div>
            <div id="address-step-vertical" class="content">
                <div class="content-header">
                    <h5 class="mb-0">Address</h5>
                    <small>Enter Your Address.</small>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="vertical-address">Address</label>
                        <input type="text" id="vertical-address" class="form-control" placeholder="98  Borough bridge Road, Birmingham" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="vertical-landmark">Landmark</label>
                        <input type="text" id="vertical-landmark" class="form-control" placeholder="Borough bridge" />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="pincode2">Pincode</label>
                        <input type="text" id="pincode2" class="form-control" placeholder="658921" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="city2">City</label>
                        <input type="text" id="city2" class="form-control" placeholder="Birmingham" />
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary btn-prev">
                        <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                    </button>
                    <button class="btn btn-primary btn-next">
                        <span class="align-middle d-sm-inline-block d-none">Next</span>
                        <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- /Vertical Wizard -->

