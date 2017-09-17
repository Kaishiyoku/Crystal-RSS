import {ReplaySubject} from "rxjs";

const notifications$ = new ReplaySubject(1);

export default notifications$;