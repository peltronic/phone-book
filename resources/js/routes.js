import VueRouter from 'vue-router'

export const routes = [

  // 404, catch all unknowns
  /*
  {
    name: 'error-not-found',
    path: '*',
    component: ErrorViews.NotFound,
  },
  */
]

const router = new VueRouter({
  mode: 'history',
  routes: routes,
})

export default router

