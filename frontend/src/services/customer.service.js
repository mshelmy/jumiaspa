import http from "../http-common";

class CustomerDataService {
  getAll() {
    return http.get("/customers");
  }

  findBy(country, state) {
    return http.get(`/customers?country=${country}&state=${state}`);
  }
}

export default new CustomerDataService();
