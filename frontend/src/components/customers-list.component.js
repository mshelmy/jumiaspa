import React, { Component } from "react";
import CustomerDataService from "../services/customer.service";
import { Link } from "react-router-dom";

export default class CustomersList extends Component {
  constructor(props) {
    super(props);
    this.onChangeSearchCountry = this.onChangeSearchCountry.bind(this);
    this.onChangeSearchState = this.onChangeSearchState.bind(this);
    this.retrieveCustomers = this.retrieveCustomers.bind(this);
    this.refreshList = this.refreshList.bind(this);
    this.setActiveCustomer = this.setActiveCustomer.bind(this);
    this.searchCountry = this.searchCountry.bind(this);
    this.searchState = this.searchState.bind(this);

    this.state = {
      customers: [],
      currentCustomer: null,
      currentIndex: -1,
      searchCountry: "",
      searchState: ""
    };
  }

  componentDidMount() {
    this.retrieveCustomers();
  }

  onChangeSearchCountry(e) {
    const searchCountry = e.target.value;

    this.setState({
      searchCountry: searchCountry
    });
  }

  onChangeSearchState(e) {
    const searchState = e.target.value;

    this.setState({
      searchState: searchState
    });
  }

  retrieveCustomers() {
    CustomerDataService.getAll()
      .then(response => {
        this.setState({
          customers: response.data
        });
        console.log(response.data);
      })
      .catch(e => {
        console.log(e);
      });
  }

  refreshList() {
    this.retrieveCustomers();
    this.setState({
      currentCustomer: null,
      currentIndex: -1
    });
  }

  setActiveCustomer(customer, index) {
    this.setState({
      currentCustomer: customer,
      currentIndex: index
    });
  }

  searchCountry() {
    CustomerDataService.findByCountry(this.state.searchCountry, this.state.searchState)
      .then(response => {
        this.setState({
          customers: response.data
        });
        console.log(response.data);
      })
      .catch(e => {
        console.log(e);
      });
  }

  searchState() {
    CustomerDataService.findBy(this.state.searchCountry, this.state.searchState)
      .then(response => {
        console.log(response.data);
        this.setState({
          customers: Array.from(response.data)
        });
      })
      .catch(e => {
        console.log(e);
      });
  }

  render() {
    const { searchCountry, searchState, customers, currentCustomer, currentIndex } = this.state;
    return (
      <div className="list row">
        <div className="col-md-8">
          <div className="input-group mb-3">
            <select 
                className="form-control"
                value={searchCountry}
                // defaultValue={this.state.searchCountry} 
                onChange={this.onChangeSearchCountry} 
            >
                <option value="">Select Country</option>
                <option value="237">Cameroon</option>
                <option value="251">Ethiopia</option>
                <option value="212">Morocco</option>
                <option value="258">Mozambique</option>
                <option value="256">Uganda</option>
            </select>

            <select 
                className="form-control"
                value={searchState}
                // defaultValue={this.state.searchCountry} 
                onChange={this.onChangeSearchState} 
            >
                <option value="">Select State</option>
                <option value="OK">OK</option>
                <option value="NOK">NOK</option>
            </select>

            <div className="input-group-append">
              <button
                className="btn btn-outline-secondary"
                type="button"
                onClick={this.searchState}
              >
                Search
              </button>
            </div>
          </div>
        </div>
        <div className="col-md-9">
          <h4>Customers List</h4>
          <table>
            <tbody>
              {customers &&
              customers.map((customer, index) => (
              <tr className={
                "list-group-item " +
                (index === currentIndex ? "active" : "")
              }
              onClick={() => this.setActiveCustomer(customer, index)}
              key={index}>
                  <td>{customer.id} &ensp;|&ensp; </td>
                  <td>{customer.name} &ensp;|&ensp; </td>
                  <td>{customer.country} &ensp;|&ensp; </td>
                  <td>{customer.code} &ensp;|&ensp; </td>
                  <td>{customer.phone} &ensp;|&ensp;&ensp; </td>
                  <td><b>{customer.state}</b></td>
              </tr>
              ))}
            </tbody>
          </table>
        </div>
        <div className="col-md-3">
          {currentCustomer ? (
            <div>
              <h4>Customer</h4>
              <div>
                <label>
                  <strong>ID:</strong>
                </label>{" "}
                {currentCustomer.id}
              </div>
              <div>
                <label>
                  <strong>Name:</strong>
                </label>{" "}
                {currentCustomer.name}
              </div>
              <div>
                <label>
                  <strong>Country:</strong>
                </label>{" "}
                {currentCustomer.country}
              </div>
              <div>
                <label>
                  <strong>Code:</strong>
                </label>{" "}
                {currentCustomer.code}
              </div>
              <div>
                <label>
                  <strong>Phone:</strong>
                </label>{" "}
                {currentCustomer.phone}
              </div>
              <div>
                <label>
                  <strong>State:</strong>
                </label>{" "}
                {currentCustomer.state}
              </div>
            </div>
          ) : (
            <div>
              <br />
              <p>Please click on a Customer...</p>
            </div>
          )}
        </div>
      </div>
    );
  }
 }
