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
                <h3 class="cart-title">Permission</h3>
                <div
                  class="card-tools"
                  style="position: absolute; top: 1rem; right: 0.5rem"
                >
                  <router-link
                    :to="{ name: 'PermissionAdd' }"
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
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(permission, index) in permissions.data"
                      :key="permission.id"
                    >
                      <td>{{ index + 1 }}</td>
                      <td v-if="permission.role">{{ permission.role.name }}</td>

                      <td>
                        <router-link
                          :to="{
                            name: 'PermissionEdit',
                            params: { id: permission.id },
                          }"
                          class="btn btn-sm btn-success"
                          >Edit</router-link
                        >
                        <button
                          class="btn btn-sm btn-warning"
                          @click.prevent="deletePermission(permission.id)"
                        >
                          Delete
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <template v-if="permissions.last_page > 1">
                <pagination-component
                  :pagination="pagination"
                  :offset="3"
                  @paginate="permissionList()"
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
  name: "PermissionList",
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
    permissionList() {
      this.$store.dispatch(
        "permission/permissionList",
        this.pagination.current_page
      );
    },
    deletePermission(id) {
      axios
        .get("/admin/delete-permission/" + id)
        .then((result) => {
          this.permissionList();
          Toast.fire({
            icon: "success",
            title: "Permission Delete successfully",
          });
        })
        .catch((err) => {});
    },
  },
  created() {
    this.permissionList();
  },
  computed: {
    permissions() {
      return this.$store.getters["permission/permissionList"];
    },
    meta() {
      return {
        current_page: this.permissions.current_page,
        last_page: this.permissions.last_page,
        from: this.permissions.from,
        to: this.permissions.to,
        per_page: this.permissions.per_page,
        total: this.permissions.total,
        path: this.permissions.path,
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
