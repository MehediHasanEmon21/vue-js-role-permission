<template>
  <div class="content-wrapper" style="min-height: 1202.48px">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"></a></li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="cart-title">User Works</h3>
                <div
                  class="card-tools"
                  style="position: absolute; top: 1rem; right: 0.5rem"
                >
                  <router-link
                    :to="{ name: 'UserWorkAdd' }"
                    class="btn btn-primary"
                  >
                    Add <i class="fas fa-plus"></i>
                  </router-link>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- <div class="mb-3">
                  <div class="row">
                    <div class="col-md-2">
                      <strong>Search By</strong>
                    </div>
                    <div class="col-md-3">
                      <select name="" id="" class="form-control">
                        <option value="name">Name</option>
                        <option value="email">Slug</option>
                      </select>
                    </div>
                    <div class="col-md-7">
                      <input type="text" class="form-control" />
                    </div>
                  </div>
                </div> -->
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>SL</th>
                      <th>Work Name</th>
                      <th>User</th>
                      <th>Department</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(user_work, index) in user_works.data"
                      :key="user_work.id"
                    >
                      <td>{{ index + 1 }}</td>
                      <td v-if="user_work.work">{{ user_work.work.name }}</td>
                      <td v-if="user_work.user">{{ user_work.user.name }}</td>
                      <td v-if="user_work.department">
                        {{ user_work.department.name }}
                      </td>

                      <td>
                        <router-link
                          :to="{
                            name: 'UserWorkEdit',
                            params: { slug: user_work.id },
                          }"
                          class="btn btn-sm btn-success"
                          >Edit</router-link
                        >
                        <button
                          class="btn btn-sm btn-danger"
                          @click.prevent="deleteUserWork(user_work.id)"
                        >
                          Delete
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <template v-if="user_works.last_page > 1">
                <pagination-component
                  :pagination="pagination"
                  :offset="3"
                  @paginate="userWorkList()"
                ></pagination-component>
              </template>

              <!-- /.card-body -->
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</template>

<script>
import PaginationComponent from "../inc/PaginationComponent";
export default {
  name: "UserWorkList",
  data() {
    return {
      pagination: {
        current_page: 1,
      },
    };
  },
  components: {
    PaginationComponent,
  },

  methods: {
    userWorkList() {
      this.$store.dispatch("work/userWorkList", this.pagination.current_page);
    },
    deleteUserWork(id) {},
  },
  created() {
    this.userWorkList();
  },
  computed: {
    user_works() {
      return this.$store.getters["work/workList"];
    },
    meta() {
      return {
        current_page: this.user_works.current_page,
        last_page: this.user_works.last_page,
        from: this.user_works.from,
        to: this.user_works.to,
        per_page: this.user_works.per_page,
        total: this.user_works.total,
        path: this.user_works.path,
      };
    },
    set() {
      return (this.pagination = this.meta);
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
