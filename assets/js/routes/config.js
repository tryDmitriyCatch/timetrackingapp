export const ROUTE_NAMES = Object.freeze({
    HOME:                     'home',
    LOGIN:                    'login',
    USER_LOGIN:               'userLogin',
    USER_LOGOUT:              'userLogout',
    WORKSPACE:                'workspace',
    ADD_TASK:                 'addTask',
    EXPORT:                   'export',
})

export const ROUTE_PATHS = new Map([
    [ROUTE_NAMES.HOME,          '/'],
    [ROUTE_NAMES.LOGIN,         '/login'],
    [ROUTE_NAMES.USER_LOGIN,    '/api_login'],
    [ROUTE_NAMES.USER_LOGOUT,   '/logout'],
    [ROUTE_NAMES.WORKSPACE,     '/workspace'],
    [ROUTE_NAMES.ADD_TASK,      '/add_task'],
    [ROUTE_NAMES.EXPORT,        '/export']
])