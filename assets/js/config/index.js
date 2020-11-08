const config = process.env

export default {
    has: function(key) {
        return typeof config[key] !== 'undefined'
    },
    get: function(key) {
        return this.has(key) ? config[key] : undefined
    },
}

export const ExportTypes = {
    'PDF': 'pdf',
    'CSV': 'csv'
}