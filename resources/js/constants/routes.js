export const ROUTES = {
    HOME: '/',
    CART: '/cart',
    LOGIN: '/login',
    REGISTER: '/register',
    DASHBOARD: '/dashboard',
    CATALOG: '/catalog',
    PRODUCT: '/product',
    CHECKOUT: '/checkout',
    PROFILE: '/profile',
    ORDERS: '/orders',
    ORDER_DETAILS: '/orders/:id',
    PASSWORD_REQUEST: '/forgot-password',
    PASSWORD_RESET: '/reset-password',
    PASSWORD_EMAIL: '/forgot-password',
    PASSWORD_UPDATE: '/reset-password',
    VERIFICATION_NOTICE: '/email/verify',
    VERIFICATION_VERIFY: '/email/verify/:id/:hash',
    VERIFICATION_SEND: '/email/verification-notification',
    LOGOUT: '/logout',
    ADMIN: {
        DASHBOARD: '/admin',
        PRODUCTS: '/admin/products',
        CATEGORIES: '/admin/categories',
        ORDERS: '/admin/orders',
        USERS: '/admin/users'
    }
}; 