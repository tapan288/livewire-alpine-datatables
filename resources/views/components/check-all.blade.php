<input x-data="checkAll" x-ref="checkAllCheckbox" @change="handleChange" type="checkbox"
    class="rounded border-gray-300 shadow">

@script
    <script>
        Alpine.data('checkAll', () => {
            return {
                init() {
                    this.$wire.watch('selectedStudentIds', () => {
                        this.updateCheckAllState()
                    })
                },
                pageIsSelected() {
                    return this.$wire.studentIdsOnPage.every(id => this.$wire.selectedStudentIds.includes(
                        id));
                },
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
                updateCheckAllState() {
                    if (this.pageIsSelected()) {
                        this.$refs.checkAllCheckbox.checked = true;
                    } else {
                        this.$refs.checkAllCheckbox.checked = false;
                    }
                }
            }
        })
    </script>
@endscript
