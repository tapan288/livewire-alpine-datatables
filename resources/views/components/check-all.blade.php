<input x-data="checkAll" @change="handleChange" type="checkbox" class="rounded border-gray-300 shadow">

@script
    <script>
        Alpine.data('checkAll', () => {
            return {
                handleChange(e) {
                    e.target.checked ? this.selectAll() : this.deselectAll()
                },
                selectAll() {
                    this.$wire.studentIdsOnPage.forEach(id => {
                        if (this.$wire.selectedStudentIds.includes(id)) return;
                        this.$wire.selectedStudentIds.push(id);
                    });
                },
                deselectAll() {
                    this.$wire.selectedStudentIds = []
                },
            }
        })
    </script>
@endscript
