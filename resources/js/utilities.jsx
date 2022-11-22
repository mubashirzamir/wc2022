import moment from 'moment'

export const sanitizeDateTime = obj => {
    let sanitizedObj = {...obj}
    sanitizedObj.date = moment(obj.date).format('YYYY-MM-DD')
    sanitizedObj.time = moment(obj.time).format('hh:mm:ss')
    return sanitizedObj
}
