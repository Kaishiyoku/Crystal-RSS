import React, {Component} from 'react';
import PropTypes from 'prop-types';
import classNames from 'classnames';
import detach from '../core/array/detach';
import concat from '../core/array/concat';

class Multiselect extends Component {
    static propTypes = {
        buttonTitle: PropTypes.string.isRequired,
        name: PropTypes.string.isRequired,
        entries: PropTypes.arrayOf(
            PropTypes.shape({
                title: PropTypes.string,
                subEntries: PropTypes.arrayOf(PropTypes.shape({
                    id: PropTypes.number,
                    title: PropTypes.string,
                })),
            })
        ).isRequired,
        selectedEntryIds: PropTypes.arrayOf(PropTypes.number).isRequired,
    };

    state = {
        selectedEntryIds: [],
    };

    componentDidMount() {
        this.setState((prevState, props) => {
            return {selectedEntryIds: props.selectedEntryIds};
        });
    }

    renderDropdownItems() {
        return this.props.entries.map((entry) => {
            return (
                <React.Fragment key={entry.title}>
                    <div className="dropdown-header">{entry.title}</div>

                    {entry.subEntries.map((subEntry) => {
                        const isEntrySelected = this.state.selectedEntryIds.includes(subEntry.id);

                        return (
                            <button
                                key={subEntry.id}
                                type="button"
                                className={classNames('dropdown-item', {'dropdown-item-active': isEntrySelected})}
                                onClick={this.handleToggleEntry(subEntry.id)}
                            >
                                {subEntry.title}
                            </button>
                        );
                    })}
                </React.Fragment>
            );
        });
    }

    handleToggleEntry = (id) => () => {
        this.setState(({selectedEntryIds}, props) => {
            const arrFn = selectedEntryIds.includes(id) ? detach : concat;

            return {selectedEntryIds: arrFn(id, selectedEntryIds)};
        });
    };

    handleSelectChange = (event) => {
        const selectedEntryIds = [...event.target.options].filter(({selected}) => selected).map(({value}) => value);

        this.setState((prevState, props) => {
            return {selectedEntryIds};
        })
    };

    handleToggleMarkAll = () => {
        this.setState((prevState, props) => {
            const allEntryIds = this.getAllEntryIds();

            const selectedEntryIds = allEntryIds.length === prevState.selectedEntryIds.length ? [] : allEntryIds;

            return {selectedEntryIds};
        });
    };

    getAllEntryIds() {
        return this.props.entries.reduce((accum, entry) => {
            return accum.concat(entry.subEntries.map((subEntry) => subEntry.id));
        }, []);
    }

    getSelectName() {
        return `${this.props.name}[]`;
    }

    getMarkAllButtonTranslation() {
        return this.getAllEntryIds().length === this.state.selectedEntryIds.length ? window.trans('select_none') : window.trans('select_all');
    }

    renderSelect() {
        return (
            <select
                name={this.getSelectName()}
                id={this.getSelectName()}
                multiple
                size={20}
                value={this.state.selectedEntryIds}
                onChange={this.handleSelectChange}
                className="hidden"
            >
                {this.props.entries.map((entry) => {
                    return (
                        <optgroup label={entry.title} key={entry.title}>
                            {entry.subEntries.map((subEntry) => {
                                return (
                                    <option value={subEntry.id} key={subEntry.id}>{subEntry.title}</option>
                                );
                            })}
                        </optgroup>
                    );
                })}
            </select>
        );
    }

    render() {
        return (
            <>
                <a
                    className="btn btn-secondary"
                    data-provide-dropdown={true}
                    data-dropdown-target={`#${this.props.id}-dropdown`}
                >
                    {this.props.buttonTitle}
                    <i className="fas fa-caret-down ml-1 mt-1"/>
                </a>

                <div id={`${this.props.id}-dropdown`} className="dropdown flex flex-col hidden rounded-md shadow-xl max-h-16 lg:max-h-32">
                    <button
                        type="button"
                        className="dropdown-item"
                        onClick={this.handleToggleMarkAll}
                    >
                        {this.getMarkAllButtonTranslation()}
                    </button>

                    <div className="dropdown-divider"/>

                    {this.renderDropdownItems()}
                </div>

                {this.renderSelect()}
            </>
        );
    }
}

export default Multiselect;
