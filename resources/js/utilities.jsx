import moment from 'moment'

export const sanitizeDateTime = obj => {
    let sanitizedObj = {...obj}
    sanitizedObj.date = moment(obj.date).format('YYYY-MM-DD')
    return sanitizedObj
}
