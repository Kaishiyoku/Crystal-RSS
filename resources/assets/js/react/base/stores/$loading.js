import {ReplaySubject} from "rxjs";

const $loading = new ReplaySubject(1);

export default $loading;