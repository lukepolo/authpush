import RequestService from "./RequestService";

export default class TokenService {
  constructor(input = null) {
    this.input = input || "token";
    this.$http = new RequestService();
  }

  submitToken(token) {
    let tokenElement = document.getElementById(this.input);
    tokenElement.value = token;
    tokenElement.form.submit();
  }

  requestApproval(token, email) {
    this.$http.request("POST", "http://2fa.codepier.test/api/otp/request", {
      email: email,
      token: token,
    });
  }
}
