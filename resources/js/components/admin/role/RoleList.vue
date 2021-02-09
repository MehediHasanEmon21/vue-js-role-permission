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
                <h3 class="cart-title">Roles</h3>
                <div
                  class="card-tools"
                  style="position: absolute; top: 1rem; right: 0.5rem"
                >
                  <router-link
                    :to="{ name: 'RoleAdd' }"
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
                    <tr v-for="(role, index) in roles.data" :key="role.id">
                      <td>{{ index + 1 }}</td>
                      <td>{{ role.name }}</td>

                      <td>
                        <router-link
                          :to="{
                            name: 'RoleEdit',
                            params: { slug: role.slug },
                          }"
                          class="btn btn-sm btn-success"
                          >Edit</router-link
                        >
                        <button
                          class="btn btn-sm btn-warning"
                          @click.prevent="deleteRole(role.slug)"
                        >
                          Delete
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <template v-if="roles.last_page > 1">
                <pagination-component
                  :pagination="pagination"
                  :offset="3"
                  @paginate="roleList()"
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
  name: "RoleList",
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
    roleList() {
      this.$store.dispatch("role/roleList", this.pagination.current_page);
    },
    deleteRole(slug) {
      axios
        .get("/admin/delete-role/" + slug)
        .then((result) => {
          this.roleList();
          Toast.fire({
            icon: "success",
            title: "Role Delete successfully",
          });
        })
        .catch((err) => {});
    },
  },
  created() {
    this.roleList();
  },
  computed: {
    roles() {
      return this.$store.getters["role/roleList"];
    },
    meta() {
      return {
        current_page: this.roles.current_page,
        last_page: this.roles.last_page,
        from: this.roles.from,
        to: this.roles.to,
        per_page: this.roles.per_page,
        total: this.roles.total,
        path: this.roles.path,
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
