$.fn.dataTableExt.afnFiltering.push(
        function (oSettings, aData, iDataIndex) {

            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1;
            var yyyy = today.getFullYear();

            if (dd < 10)
                dd = '0' + dd;

            if (mm < 10)
                mm = '0' + mm;

            today = yyyy + '-' + mm + '-' + dd;

                var iMin_temp = $('#datefrom').val();
                if (iMin_temp === '') {
                    iMin_temp = '1980-01-01';
                }

                var iMax_temp = $('#dateto').val();
                if (iMax_temp === '') {
                    iMax_temp = today;
                }

                var arr_min = iMin_temp.split("-");
                var arr_max = iMax_temp.split("-");
                var arr_date = aData[5].split("-");

                var iMin = new Date(arr_min[2], arr_min[0], arr_min[1], 0, 0, 0, 0);
                var iMax = new Date(arr_max[2], arr_max[0], arr_max[1], 0, 0, 0, 0);
                var iDate = new Date(arr_date[2], arr_date[0], arr_date[1], 0, 0, 0, 0);

                if (iMin === "" && iMax === "")
                {
                    return true;
                }
                else if (iMin === "" && iDate < iMax)
                {
                    return true;
                }
                else if (iMin <= iDate && "" === iMax)
                {
                    return true;
                }
                else if (iMin <= iDate && iDate <= iMax)
                {
                    return true;
                }
                return false;
        }
    );