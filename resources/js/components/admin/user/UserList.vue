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
                <h3 class="cart-title">Users</h3>
                <div
                  class="card-tools"
                  style="position: absolute; top: 1rem; right: 0.5rem"
                >
                  <router-link
                    :to="{ name: 'UserAdd' }"
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
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Status</th>
                      <th>Department(Role)</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(user, index) in users.data" :key="user.id">
                      <td>{{ index + 1 }}</td>
                      <td>{{ user.name }}</td>
                      <td>{{ user.email }}</td>
                      <td>{{ user.phone }}</td>
                      <td v-if="user.status == 1">
                        <span class="badge bg-success">active</span>
                      </td>
                      <td v-else>
                        <span class="badge bg-danger">inactive</span>
                      </td>
                      <td v-if="user.department">
                        {{ user.department.name }}({{ user.role.name }})
                      </td>
                      <td v-else>({{ user.role.name }})</td>

                      <td>
                        <router-link
                          :to="{
                            name: 'UserEdit',
                            params: { slug: user.slug },
                          }"
                          class="btn btn-sm btn-success"
                          >Edit</router-link
                        >
                        <button
                          class="btn btn-sm btn-danger"
                          @click.prevent="deleteUser(user.slug)"
                        >
                          Delete
                        </button>
                        <button
                          @click.prevent="userInactive(user.id)"
                          v-if="user.status == 1"
                          class="btn btn-sm btn-warning"
                        >
                          Inactive
                        </button>
                        <button
                          @click.prevent="userActive(user.id)"
                          v-else
                          class="btn btn-sm btn-info"
                        >
                          Active
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <template v-if="users.last_page > 1">
                <pagination-component
                  :pagination="pagination"
                  :offset="3"
                  @paginate="userList()"
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
  name: "UserList",
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
    userList() {
      this.$store.dispatch("user/userList", this.pagination.current_page);
    },
    deleteUser(slug) {
      axios
        .get("/admin/delete-user/" + slug)
        .then((result) => {
          this.userList();
          Toast.fire({
            icon: "success",
            title: "User Delete successfully",
          });
        })
        .catch((err) => {});
    },
    userInactive(id) {
      let r = confirm("Are you sure to inactive this user!");
      if (r == true) {
        axios
          .get("/admin/inactive-user/" + id)
          .then((result) => {
            this.userList();
            Toast.fire({
              icon: "success",
              title: "User Inactive successfully",
            });
          })
          .catch((err) => {});
      }
    },
    userActive(id) {
      let r = confirm("Are you sure to active this user!");
      if (r == true) {
        axios
          .get("/admin/active-user/" + id)
          .then((result) => {
            this.userList();
            Toast.fire({
              icon: "success",
              title: "User active successfully",
            });
          })
          .catch((err) => {});
      }
    },
  },
  created() {
    this.userList();
  },
  computed: {
    users() {
      return this.$store.getters["user/userList"];
    },
    meta() {
      return {
        current_page: this.users.current_page,
        last_page: this.users.last_page,
        from: this.users.from,
        to: this.users.to,
        per_page: this.users.per_page,
        total: this.users.total,
        path: this.users.path,
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
