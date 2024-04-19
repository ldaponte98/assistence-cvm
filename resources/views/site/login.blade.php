<script>
    let key = "{{ env('GENESIS_KEY') }}"
    let redirect = "{{ env('GENESIS_AUTH') }}"
    location.href = `${redirect}/${key}`
</script>