import moment from "moment";

export function useMomentJS() {
    const getDatesBetween = (startDate, endDate, format = 'MM/DD/YYYY HH:mm:ss') => {
        startDate = moment(startDate);
        endDate = moment(endDate);

        var now = startDate, dates = [];

        while (now.isBefore(endDate) || now.isSame(endDate)) {
            dates.push(now.format(format));
            now.add(1, 'days');
        }

        return dates;
    };

    const dateFormat = (value, format = 'MM/DD/YYYY') => moment(value).format(format);

    const formatDateZone = (value, format = 'MM/DD/YYYY') => moment.parseZone(value).format(format);

    return {
        getDatesBetween,
        dateFormat,
        formatDateZone,
    };
};
