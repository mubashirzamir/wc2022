export const sanitizeDateTime = obj => {
    return {
        date: obj.date.format('YYYY-MM-DD'),
        ...obj
    }
}
