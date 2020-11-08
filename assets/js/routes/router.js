import { generatePath as baseGeneratePath } from 'react-router-dom'
import { ROUTE_PATHS } from './config'

export function generatePath(routeName, params = {}) {
    return baseGeneratePath(ROUTE_PATHS.get(routeName), params)
}