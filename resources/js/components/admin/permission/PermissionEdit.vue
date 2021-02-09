<template>
  <div class="content-wrapper" style="min-height: 1203.6px">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"></a></li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Permission</h3>
              </div>

              <form role="form" @submit.prevent="editPermission">
                <div class="card-body">
                  <div class="form-group">
                    <label for="category_name">Role</label>
                    <select v-model="form.role_id" class="form-control">
                      <option value="">Select Role</option>
                      <option
                        :value="role.id"
                        v-for="role in roles"
                        :key="role.id"
                      >
                        {{ role.name }}
                      </option>
                    </select>
                    <small style="color: red" v-if="errors['role_id']">{{
                      errors["role_id"][0]
                    }}</small>
                  </div>

                  <div class="form-group">
                    <table class="table table-responsive table-striped">
                      <thead>
                        <tr>
                          <th>Permission</th>
                          <th>Add</th>
                          <th>Edit</th>
                          <th>View</th>
                          <th>Delete</th>
                          <th>List</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Roles</td>
                          <td>
                            <input
                              type="checkbox"
                              v-model="form.permission.roles"
                              value="add"
                            />
                          </td>
                          <td>
                            <input
                              type="checkbox"
                              v-model="form.permission.roles"
                              value="edit"
                            />
                          </td>
                          <td>
                            <input
                              type="checkbox"
                              v-model="form.permission.roles"
                              value="view"
                            />
                          </td>
                          <td>
                            <input
                              type="checkbox"
                              v-model="form.permission.roles"
                              value="delete"
                            />
                          </td>
                          <td>
                            <input
                              type="checkbox"
                              v-model="form.permission.roles"
                              value="list"
                            />
                          </td>
                        </tr>
                        <tr>
                          <td>Permissions</td>
                          <td>
                            <input
                              type="checkbox"
                              v-model="form.permission.permissions"
                              value="add"
                            />
                          </td>
                          <td>
                            <input
                              type="checkbox"
                              v-model="form.permission.permissions"
                              value="edit"
                            />
                          </td>
                          <td>
                            <input
                              type="checkbox"
                              v-model="form.permission.permissions"
                              value="view"
                            />
                          </td>
                          <td>
                            <input
                              type="checkbox"
                              v-model="form.permission.permissions"
                              value="delete"
                            />
                          </td>
                          <td>
                            <input
                              type="checkbox"
                              v-model="form.permission.permissions"
                              value="list"
                            />
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
          <div class="col-md-3"></div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</template>

<script>
export default {
  name: "PermissionEdit",
  data() {
    return {
      form: {},

      errors: {},
    };
  },

  methods: {
    allRole() {
      this.$store.dispatch("role/allRole");
    },
    editPermission() {
      axios
        .post("/admin/update-permission", this.form)
        .then((result) => {
          Toast.fire({
            icon: "success",
            title: "Permission Update successfully",
          });
          this.$router.push({ name: "PermissionList" });
        })
        .catch((err) => {
          this.errors = err.response.data.errors;
        });
    },
    edit() {
      axios
        .get("/admin/edit-permission/" + this.$route.params.id)
        .then((result) => {
          this.form = result.data.permission;
        })
        .catch((err) => {});
    },
  },
  created() {
    this.allRole();
    this.edit();
  },
  computed: {
    roles() {
      return this.$store.getters["role/roleList"];
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
