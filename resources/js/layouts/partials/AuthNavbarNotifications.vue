<template>
  <div class="dropdown dropdown-notifications">
    <a
      href="#"
      class="
        btn btn-icon btn-rounded btn-flush-dark
        flush-soft-hover
        dropdown-toggle
        no-caret
      "
      data-bs-toggle="dropdown"
      data-dropdown-animation
      role="button"
      aria-haspopup="true"
      aria-expanded="false"
      ><span class="icon"
        ><span class="position-relative"
          ><span class="feather-icon"><i data-feather="bell"></i></span
          ><span
            class="
              badge badge-success badge-indicator
              position-top-end-overflow-1
            "
          ></span></span></span
    ></a>
    <div class="dropdown-menu dropdown-menu-end p-0">
      <h6 class="dropdown-header px-4 fs-6">
        Notifications<a
          href="#"
          class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
          ><span class="icon"
            ><span class="feather-icon"
              ><i data-feather="settings"></i></span></span
        ></a>
      </h6>
      <div data-simplebar class="dropdown-body p-2">
        <a href="javascript:void(0);" class="dropdown-item">
          <div class="media">
            <div class="media-head">
              <div class="avatar avatar-rounded avatar-sm">
                <img src="/jampack/avatar2.jpg" alt="user" class="avatar-img" />
              </div>
            </div>
            <div class="media-body">
              <div>
                <div class="notifications-text">
                  Morgan Freeman accepted your invitation to join the team
                </div>
                <div class="notifications-info">
                  <span class="badge badge-soft-success">Collaboration</span>
                  <div class="notifications-time">Today, 10:14 PM</div>
                </div>
              </div>
            </div>
          </div>
        </a>
        <a href="javascript:void(0);" class="dropdown-item">
          <div class="media">
            <div class="media-head">
              <div
                class="
                  avatar avatar-icon avatar-sm avatar-success avatar-rounded
                "
              >
                <span class="initial-wrap">
                  <span class="feather-icon"><i data-feather="inbox"></i></span>
                </span>
              </div>
            </div>
            <div class="media-body">
              <div>
                <div class="notifications-text">
                  New message received from Alan Rickman
                </div>
                <div class="notifications-info">
                  <div class="notifications-time">Today, 7:51 AM</div>
                </div>
              </div>
            </div>
          </div>
        </a>
        <a href="javascript:void(0);" class="dropdown-item">
          <div class="media">
            <div class="media-head">
              <div
                class="avatar avatar-icon avatar-sm avatar-pink avatar-rounded"
              >
                <span class="initial-wrap">
                  <span class="feather-icon"><i data-feather="clock"></i></span>
                </span>
              </div>
            </div>
            <div class="media-body">
              <div>
                <div class="notifications-text">
                  You have a follow up with Jampack Head on Friday, Dec 19 at
                  9:30 am
                </div>
                <div class="notifications-info">
                  <div class="notifications-time">Yesterday, 9:25 PM</div>
                </div>
              </div>
            </div>
          </div>
        </a>
        <a href="javascript:void(0);" class="dropdown-item">
          <div class="media">
            <div class="media-head">
              <div class="avatar avatar-sm avatar-rounded">
                <img src="/jampack/avatar3.jpg" alt="user" class="avatar-img" />
              </div>
            </div>
            <div class="media-body">
              <div>
                <div class="notifications-text">
                  Application of Sarah Williams is waiting for your approval
                </div>
                <div class="notifications-info">
                  <div class="notifications-time">Today 10:14 PM</div>
                </div>
              </div>
            </div>
          </div>
        </a>
        <a href="javascript:void(0);" class="dropdown-item">
          <div class="media">
            <div class="media-head">
              <div class="avatar avatar-sm avatar-rounded">
                <img
                  src="/jampack/avatar10.jpg"
                  alt="user"
                  class="avatar-img"
                />
              </div>
            </div>
            <div class="media-body">
              <div>
                <div class="notifications-text">
                  Winston Churchil shared a document with you
                </div>
                <div class="notifications-info">
                  <span class="badge badge-soft-violet">File Manager</span>
                  <div class="notifications-time">2 Oct, 2021</div>
                </div>
              </div>
            </div>
          </div>
        </a>
        <a href="javascript:void(0);" class="dropdown-item">
          <div class="media">
            <div class="media-head">
              <div
                class="
                  avatar avatar-icon avatar-sm avatar-danger avatar-rounded
                "
              >
                <span class="initial-wrap">
                  <span class="feather-icon"
                    ><i data-feather="calendar"></i
                  ></span>
                </span>
              </div>
            </div>
            <div class="media-body">
              <div>
                <div class="notifications-text">
                  Last 2 days left for the project to be completed
                </div>
                <div class="notifications-info">
                  <span class="badge badge-soft-orange">Updates</span>
                  <div class="notifications-time">14 Sep, 2021</div>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>
      <div class="dropdown-footer">
        <a href="#"><u>View all notifications</u></a>
      </div>
    </div>
  </div>
</template>
