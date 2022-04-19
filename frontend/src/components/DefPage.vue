<template>
  <section style="background-color: #9de2ff">
    <div class="container py-5">
      <div class="flex-card">
        <div class="col col-md-9 col-lg-7 col-xl-5">
          <div class="card" style="border-radius: 15px">
            <div class="card-body p-4">
              <div class="d-flex text-black">
                <div class="flex-avatar">
                  <div class="avatar-image">
                    <div>
                      <img
                        src="../assets/img/default/def-user.png"
                        class="img-fluid"
                        alt="def-avatar"
                      />
                    </div>
                  </div>
                </div>
                <div class="flex-info">
                  <h5 class="mb-1">Неизвестный</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="alert alert-info d-flex justify-content-center mt-2" role="alert">
    Этот профиль еще не создан.
  </div>
</template>

<script>
export default {
  name: "DefPage",
};
</script>
