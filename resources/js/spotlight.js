import Fuse from 'fuse.js'

window.SpotlightComponent = (config) => {
    return {
        isOpen: false,
        input: '',
        selected: 0,
        commands: config.commands,
        commandSearch: null,
        _visibleIds: [],

        selectedCommand: null,
        currentDependency: null,
        requiredDependencies: [],
        resolvedDependencies: {},
        dependencySearch: null,
        dependencyQueryResults: config.componentId
            ? window.Livewire.find(config.componentId).entangle('dependencyQueryResults')
            : [],

        init() {
            this.commandSearch = new Fuse(this.commands, {
                threshold: 0.3,
                keys: ['name', 'description', 'synonyms'],
            })
            this.dependencySearch = new Fuse([], {
                threshold: 0.3,
                keys: ['name', 'description', 'synonyms'],
            })

            this._visibleIds = this._sortedCommands().map(c => c.id)

            this.$watch('dependencyQueryResults', value => {
                this.dependencySearch.setCollection(value)
                this.selected = 0
            })

            this.$watch('input', value => {
                this.selected = 0
                if (this.selectedCommand !== null && this.currentDependency !== null && this.currentDependency.type === 'search') {
                    if (value.length >= 2) {
                        this.$wire.searchDependency(this.selectedCommand.id, this.currentDependency.id, value, this.resolvedDependencies)
                    }
                } else {
                    this._visibleIds = this._computeVisibleIds()
                }
            })

            this.$watch('isOpen', value => {
                if (!value) {
                    setTimeout(() => {
                        this.input = ''
                        this.selected = 0
                        this.selectedCommand = null
                        this.currentDependency = null
                        this.requiredDependencies = []
                        this.resolvedDependencies = {}
                        this._visibleIds = this._sortedCommands().map(c => c.id)
                    }, 200)
                }
            })
        },

        toggleOpen() {
            if (this.isOpen) {
                this.isOpen = false
                return
            }
            this.input = ''
            this.isOpen = true
            setTimeout(() => this.$refs.input.focus(), 100)
        },

        get isInDependencyMode() {
            return this.selectedCommand !== null
        },

        _sortedCommands() {
            const groupOrder = [...new Set(this.commands.map(c => c.group))]
            return [...this.commands].sort((a, b) => {
                return groupOrder.indexOf(a.group) - groupOrder.indexOf(b.group)
            })
        },

        _computeVisibleIds() {
            if (!this.input) {
                return this._sortedCommands().map(c => c.id)
            }
            const matchedIds = this.commandSearch.search(this.input).map(r => r.item.id)
            return this._sortedCommands().filter(c => matchedIds.includes(c.id)).map(c => c.id)
        },

        visibleIds() {
            return this._visibleIds
        },

        isVisible(id) {
            return this._visibleIds.includes(id)
        },

        isSelected(id) {
            return this._visibleIds[this.selected] === id
        },

        groupHasVisibleItems(group) {
            return this.commands
                .filter(c => c.group === group)
                .some(c => this._visibleIds.includes(c.id))
        },

        dependencyResults() {
            if (!this.input) {
                return this.dependencySearch.getIndex().docs.map((item, i) => [{ item }, i])
            }
            return this.dependencySearch.search(this.input).map((item, i) => [item, i])
        },

        _scrollToSelected() {
            this.$nextTick(() => {
                const container = this.isInDependencyMode
                    ? this.$refs.dependencyResultsList
                    : this.$refs.commandResults
                if (!container) return
                const items = [...container.querySelectorAll('[data-spotlight-item]')]
                    .filter(el => el.offsetParent !== null)
                const item = items[this.selected]
                item?.scrollIntoView({ block: 'nearest' })
            })
        },

        selectUp() {
            this.selected = Math.max(0, this.selected - 1)
            this._scrollToSelected()
        },

        selectDown() {
            let max
            if (this.isInDependencyMode) {
                max = this.dependencyResults().length - 1
            } else {
                max = this._visibleIds.length - 1
            }
            this.selected = Math.min(max, this.selected + 1)
            this._scrollToSelected()
        },

        go(id) {
            if (this.selectedCommand === null) {
                const commandId = id || this._visibleIds[this.selected]
                const command = this.commands.find(c => c.id === commandId)
                if (!command) return

                if (command.dependencies.length === 0) {
                    this.$wire.executeCommand(command.id)
                    return
                }

                this.selectedCommand = command
                this.requiredDependencies = JSON.parse(JSON.stringify(command.dependencies))
                this.input = ''
                this.currentDependency = this.requiredDependencies.pop()
                return
            }

            if (this.currentDependency !== null) {
                const results = this.dependencyResults()
                const result = id
                    ? results.find(r => r[0].item.id == id)
                    : results[this.selected]

                if (!result) return

                this.resolvedDependencies[this.currentDependency.id] = result[0].item.id
            }

            if (this.requiredDependencies.length > 0) {
                this.input = ''
                this.currentDependency = this.requiredDependencies.pop()
            } else {
                this.isOpen = false
                this.$wire.execute(this.selectedCommand.id, this.resolvedDependencies)
            }
        },

        goBack() {
            if (this.selectedCommand !== null) {
                this.selectedCommand = null
                this.currentDependency = null
                this.requiredDependencies = []
                this.resolvedDependencies = {}
                this.input = ''
                this._visibleIds = this._sortedCommands().map(c => c.id)
            } else {
                this.isOpen = false
            }
        },
    }
}
