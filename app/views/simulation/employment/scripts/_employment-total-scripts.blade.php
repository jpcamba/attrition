<script>
    //User Values Chart
    var ft = {{json_encode($input['ft'])}};
    var pt = {{json_encode($input['pt'])}};
    var ne = {{json_encode($input['ne'])}};

    Morris.Donut({
        element: 'values',
        data: [
            {label: "Full-time", value: ft},
            {label: "Part-time", value: pt},
            {label: "Not Employed", value: ne}
        ]
    });

    data = (ft + pt) / 100;

    //Attrition Results Chart
    var attrition = {{json_encode($attrition)}};
    var retention = 100 - attrition;

    Morris.Donut({
        element: 'attrition',
        data: [
            {label: 'Attrition', value: attrition},
            {label: 'Retention', value: retention}
        ]
    });


</script>